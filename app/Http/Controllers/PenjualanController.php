<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stok;
use App\Models\Sales;
use App\Models\Reciepents;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $penerima = Reciepents::all();
        $user = Auth::user(); // Ambil user yang login

        if ($user->hasRole('admin')) {
            // Kalau admin, ambil semua data
            $distributor = Distributor::all();
            $sales = Sales::all();
        } else {
            // Kalau distributor, hanya ambil data distributor dan sales miliknya
            $distributor = Distributor::where('id_user', $user->id)->get();

            // Ambil semua sales yang terkait dengan distributor ini
            $sales = Sales::whereIn('id_toko', $distributor->pluck('id'))->get();
        }


        return view('penjualan.index',compact(['sales', 'distributor','penerima' ]));
    }

    public function filter(Request $request)
    {
        $distributorId = $request->distributor_id;

        $query = Sales::with(['penerima', 'distributor']);

        if ($distributorId) {
            $query->where('id_distributor', $distributorId);
        }

        $sales = $query->get();

        return view('partials.sales_table', compact('sales'));
    }
    
    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            // Admin bisa pilih distributor
            $distributors = Distributor::all();
        } else {
            // Distributor hanya bisa pilih dirinya sendiri
            $distributors = Distributor::where('id_user', $user->id)->get();
        }
        $penerima = Reciepents::all(); 
        return view('penjualan.create', compact(['distributor', 'penerima']));
    }



    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomor_transaksi',
                'id_penerima' => 'required',
                'id_toko' => 'required',
                'jumlah_barang' => 'required|numeric',
                'harga_satuan' => 'required|numeric',
                'total_harga' => 'required|numeric',
            ]);

            // Generate nomor transaksi otomatis
            $tanggal = now()->format('Ymd'); // contoh: 20250425
            
            $prefix = 'TRX-' . $tanggal;

            // Hitung transaksi pada hari ini
            $latestTransaksi = Sales::whereDate('created_at', now()->toDateString())
                ->orderBy('nomor_transaksi', 'desc')
                ->first();

            $lastNumber = 0;
            if ($latestTransaksi && preg_match('/\-(\d+)$/', $latestTransaksi->nomor_transaksi, $match)) {
                $lastNumber = (int)$match[1];
            }

            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // hasil: 001, 002, dst
            $nomor_transaksi = $prefix . '-' . $newNumber;

            // Simpan penjualan
            Sales::create([
                'nomor_transaksi' => $nomor_transaksi,
                'id_penerima' => $request->id_penerima,
                'id_toko' => $request->id_toko,
                'jumlah_barang' => $request->jumlah_barang,
                'harga_satuan' => $request->harga_satuan,
                'total_harga' => $request->total_harga,
            ]);

            // Kurangi stok sesuai jumlah pembelian
            $stok = Stok::where('id_toko', $request->id_toko)->first();

            if (!$stok) {
                return redirect()->back()->with('error', 'Stok untuk toko ini tidak ditemukan.')->withInput();
            }

            if ($stok->jumlah_barang < $request->jumlah_barang) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.')->withInput();
            }

            $stok->jumlah_barang -= $request->jumlah_barang;
            $stok->save();

            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    //laporan penjualan
    public function printRange(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = Carbon::parse($request->from)->startOfDay();
        $to = Carbon::parse($request->to)->endOfDay();

        $query = Sales::with(['penerima', 'distributor'])
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at', 'asc');

        // Cek role user
        $judul = 'Laporan Penjualan';

        if (Auth::user()->hasRole('distributor')) {
            $distributor = Distributor::where('id_user', Auth::id())->first();
            if ($distributor) {
                $query->where('id_toko', $distributor->id);
                $judul .= ' - ' . $distributor->nama_toko;
            }
        } elseif (Auth::user()->hasRole('admin')) {
            if (!empty($request->id_toko)) {
                $query->where('id_toko', $request->id_toko);
                $distributor = Distributor::find($request->id_toko);
                if ($distributor) {
                    $judul .= ' - ' . $distributor->nama_toko;
                }
            }
        }

        $sales = $query->get();

        $pdf = Pdf::loadView('penjualan.print-range', compact('sales', 'from', 'to','judul'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Laporan-Penjualan-' . $from->format('j F Y') . '-sampai-' . $to->format('j F Y') . '.pdf');
    }
        


    
}
