<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DistributorController extends Controller
{
    /**
     * Tampilkan form tambah data distributor.
     */
    public function create()
    {
        $distributors = Distributor::all();
        return view('distributor.create');
    }

    /**
     * Simpan data distributor ke database.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat'  => 'required|string',
            'no_hp'   => 'required|string|max:15',
        ]);

        $user = User::find(Auth::id());

        // Cek jika user punya role "distributor"
        if ($user->hasRole('distributor')) {
            // Cek jika user belum punya data distributor
            if (!$user->distributor) {
                // Simpan data distributor
                Distributor::create([
                    'id_user'  => $user->id,
                    'nama_toko'  => $request->nama_toko,
                    'alamat'   => $request->alamat,
                    'no_hp'    => $request->no_hp,
                ]);

                return redirect()->route('dashboard')->with('success', 'Data distributor berhasil disimpan.');
            } else {
                return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki data distributor.');
            }
        }

        // Jika bukan distributor, arahkan ke dashboard langsung
        return redirect()->route('dashboard');
    }
}

