<?php

namespace App\Http\Controllers;

use App\Models\Reciepents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PenerimaController extends Controller
{

    public function index()
    {
        $reciepents = Reciepents::all();
        return view('penerima.index', compact('reciepents'));
    }

    public function create()
    {
        return view('penerima.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pengguna' => 'required|in:Rumah Tangga,UMKM',
        ]);

        try {
            if ($request->jenis_pengguna === 'Rumah Tangga') {
                $request->validate([
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|numeric|',
                    'alamat' => 'required|string',
                    'no_hp' => 'required|string|max:15',
                    'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                $fotoKTPPath = null;
                if ($request->hasFile('foto_ktp')) {
                    $fotoKTPPath = $request->file('foto_ktp')->store('foto_ktp', 'public');
                }

                // dd($request->all());

                Reciepents::create([
                    'jenis_pengguna' => $request->jenis_pengguna,
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'foto_ktp' => $fotoKTPPath,
                ]);
            } elseif ($request->jenis_pengguna === 'UMKM') {
                $request->validate([
                    'nama_usaha' => 'required|string|max:255',
                    'nib' => 'required|string|max:30',
                    'foto_usaha' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                $fotoUsahaPath = null;
                if ($request->hasFile('foto_usaha')) {
                    $fotoUsahaPath = $request->file('foto_usaha')->store('foto_usaha', 'public');
                }

                Reciepents::create([
                    'jenis_pengguna' => $request->jenis_pengguna,
                    'nama_usaha' => $request->nama_usaha,
                    'nib' => $request->nib,
                    'foto_usaha' => $fotoUsahaPath,
                ]);
            }

            return redirect()->route('penerima.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan penerima subsidi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function destroy($id)
    {
        Reciepents::find($id)->delete();
        return redirect()->route('penerima.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id)
    {
        $reciepents = Reciepents::find($id);
        return view('penerima.edit', compact('reciepents'));
    }

    public function update(Request $request, $id)
    {
        try {
            $reciepents = Reciepents::findOrFail($id);

            if ($request->jenis_pengguna === 'Rumah Tangga') {
                $request->validate([
                    'jenis_pengguna' => 'required|in:Rumah Tangga,UMKM',
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|numeric|digits:16|unique:reciepents,nik,' . $id,
                    'alamat' => 'required|string',
                    'no_hp' => 'required|string|max:15',
                    'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                $reciepents->update([
                    'jenis_pengguna' => $request->jenis_pengguna,
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'foto_ktp' => $request->hasFile('foto_ktp') ? $request->file('foto_ktp')->store('foto_ktp', 'public') : $reciepents->foto_ktp,
                    'nama_usaha' => null,
                    'nib' => null,
                    'foto_usaha' => null,
                ]);
            } elseif ($request->jenis_pengguna === 'UMKM') {
                $request->validate([
                    'jenis_pengguna' => 'required|in:Rumah Tangga,UMKM',
                    'nama_usaha' => 'required|string|max:255',
                    'nib' => 'required|string|max:30',
                    'foto_usaha' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                $reciepents->update([
                    'jenis_pengguna' => $request->jenis_pengguna,
                    'nama_usaha' => $request->nama_usaha,
                    'nib' => $request->nib,
                    'foto_usaha' => $request->hasFile('foto_usaha') ? $request->file('foto_usaha')->store('foto_usaha', 'public') : $reciepents->foto_usaha,
                    // Kosongkan data rumah tangga jika sebelumnya UMKM berubah
                    'nama' => null,
                    'nik' => null,
                    'alamat' => null,
                    'no_hp' => null,
                    'foto_ktp' => null,
                ]);
            }

            return redirect()->route('penerima.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error saat update penerima: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

}
