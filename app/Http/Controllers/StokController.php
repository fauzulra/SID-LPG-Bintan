<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with('distributor')->get();
        $distributors = Distributor::all();
        return view('stok.index', compact(['stok','distributors']));
    }

    public function create()
    {
        
        view('stok.create', compact('distributors'));
    }

    public function store(Request $request)
    {
     try {
        $request->validate([
            'id_toko' => 'required',
            'jumlah_barang' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
        
        ]);  

        // Cek apakah stok untuk id_toko ini sudah ada
        $stok = Stok::where('id_toko', $request->id_toko)->first();

        if ($stok) {
            // Jika ada, update jumlah_barang-nya
            $stok->update([
                'jumlah_barang' => $stok->jumlah_barang + $request->jumlah_barang,
                'tanggal_masuk' => $request->tanggal_masuk, 
            ]);
        } else {
            // Jika tidak ada, buat data baru
            Stok::create([
                'id_toko' => $request->id_toko,
                'jumlah_barang' => $request->jumlah_barang,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);
        }
            return redirect()->route('stok.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    
    }

    public function destroy($id)
    {

    }
}

