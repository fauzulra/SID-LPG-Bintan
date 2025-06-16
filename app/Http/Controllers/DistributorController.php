<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DistributorController extends Controller
{


    public function index()
    {
        $user = User::find(Auth::id());
        $distributor = Distributor::with('user')->get();

        return view('distributor.index', compact(['distributor', 'user']));
    }
    public function profile()
    {
        $user = User::find(Auth::id());
        $distributor = Distributor::where('id_user', $user->id)->first();

        return view('distributor.profile', compact('distributor'));
    }

    public function edit()
    {
        $id = Auth::id();
        $distributor = Distributor::with('user')->find($id);
        return view('distributor.edit', compact('distributor'));
    }

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

    public function update(Request $request)
    {
        $user = Auth::user();
        $distributor = $user->distributor; 

        // Update data
        $distributor->nama_toko = $request->nama_toko;
        $distributor->alamat = $request->alamat;
        $distributor->no_hp = $request->no_hp;
        $distributor->save();

        return redirect()->back()->with('success', 'Profil Pengguna Berhasil Diperbarui!');
    }

    public function toggleApproval(User $user)
{
    $user->is_approved = !$user->is_approved;
    $user->save();

    return redirect()->back()->with('success', 'Status approval berhasil diperbarui.');

}
    public function destroy(User $user)
{
    // Hapus distributor terkait (jika ada)
    $user->distributor()->delete();

    // Hapus user
    $user->delete();

    return redirect()->back()->with('success', 'Akun distributor berhasil dihapus.');
}

}