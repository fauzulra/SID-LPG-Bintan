<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\User;
use App\Models\Sales;
use App\Models\Reciepents;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()

    {
        $user = User::find(Auth::id());
        //function untuk membuat data distributor
        if ($user && $user->hasRole('distributor') && $user->distributor === null) {
            return redirect()->route('distributor.create');
        }

        if ($user && $user->hasRole('distributor') && !$user->is_approved) {
            return view('auth.waiting_approval');
        }

        $penerima = Reciepents::all();
        $distributor = Distributor::all();
        $sales = Sales::all(); 

        //akses data dashboard berdasarkan role

        if ($user->hasRole('admin')) {
            // Admin melihat semua transaksi
            $sales = Sales::with(['penerima', 'distributor'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } else {
            // Distributor hanya melihat transaksi miliknya
            $distributor = Distributor::where('id_user', $user->id)->first();

            if ($distributor) {
                $sales = Sales::with(['penerima', 'distributor'])
                    ->where('id_toko', $distributor->id) // filter hanya tokonya
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $sales = collect(); // kalau tidak punya distributor, kosongkan data
            }
        }


        //function untuk membuat card penjualan
        if ($user->hasRole('admin')) {
            $salesdata = Sales::sum('jumlah_barang'); 
        } else {
            $distributor = Distributor::where('id_user', $user->id)->first();

            if ($distributor) {
                $salesdata = Sales::where('id_toko', $distributor->id)
                    ->sum('jumlah_barang'); 
            } else {
                $salesdata = 0; 
            }
        }

        //function untuk membuat card stok
        if ($user->hasRole('admin')) {
            $stokdata = Stok::sum('jumlah_barang'); // Total semua barang terjual
        } else {
            $distributor = Distributor::where('id_user', $user->id)->first();

            if ($distributor) {
                $stokdata = Stok::where('id_toko', $distributor->id)
                    ->sum('jumlah_barang'); // Total barang terjual hanya dari distributornya
            } else {
                $stokdata = 0; // Kalau distributor gak punya toko
            }
        }

        //function untuk membuat chart pie
        if ($user->hasRole('admin')) {
            // Admin melihat semua
            $totalStok = Stok::sum('jumlah_barang');
            $totalTerjual = Sales::sum('jumlah_barang');
        } else {
            // Distributor melihat tokonya sendiri
            $distributor = Distributor::where('id_user', $user->id)->first();

            if ($distributor) {
                $totalStok = Stok::where('id_toko', $distributor->id)->sum('jumlah_barang');
                $totalTerjual = Sales::where('id_toko', $distributor->id)->sum('jumlah_barang');
            } else {
                $totalStok = 0;
                $totalTerjual = 0;
            }
        }

        //function untuk membuat notifikasi
        $lowStockAdmin = [];
        $lowStockDistributor = [];
        if ($user->hasRole('admin')) {
            $lowStockAdmin = DB::table('stoks')
                ->join('distributors', 'stoks.id_toko', '=', 'distributors.id')
                ->select('distributors.nama_toko', DB::raw('SUM(jumlah_barang) as total_stok'))
                ->groupBy('stoks.id_toko', 'distributors.nama_toko')
                ->having('total_stok', '<', 20)
                ->get();
        } else {
            $lowStockDistributor = Stok::where('id_toko', $user->distributor->id)  
                ->where('jumlah_barang', '<', 20)  
                ->get();
        }





        return view('auth.dashboard',compact('penerima', 'distributor', 'sales','salesdata','stokdata','totalStok','totalTerjual','lowStockDistributor','lowStockAdmin'));
        
    }

    


   



}
