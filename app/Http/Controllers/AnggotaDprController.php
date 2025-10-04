<?php

namespace App\Http\Controllers;

use App\Models\AnggotaDpr;
use Illuminate\Http\Request;

class AnggotaDprController extends Controller
{
    // Menampilkan daftar anggota (READ)
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $anggota = AnggotaDpr::when($search, function($query, $search) {
            return $query->where('nama_depan', 'like', "%{$search}%")
                        ->orWhere('nama_belakang', 'like', "%{$search}%")
                        ->orWhere('jabatan', 'like', "%{$search}%")
                        ->orWhere('id_anggota', 'like', "%{$search}%");
        })->orderBy('id_anggota', 'desc')->paginate(10);
        
        return view('anggota.index', compact('anggota', 'search'));
    }

    // Menampilkan form tambah anggota (CREATE - Form)
    public function create()
    {
        return view('anggota.create');
    }

    // Menyimpan data anggota baru (CREATE - Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'status_pernikahan' => 'required|in:Kawin,Belum Kawin',
            'jumlah_anak' => 'required|integer|min:0',
        ], [
            'nama_depan.required' => 'Nama depan wajib diisi',
            'jabatan.required' => 'Jabatan wajib dipilih',
            'status_pernikahan.required' => 'Status pernikahan wajib dipilih',
            'jumlah_anak.required' => 'Jumlah anak wajib diisi',
            'jumlah_anak.integer' => 'Jumlah anak harus berupa angka',
            'jumlah_anak.min' => 'Jumlah anak minimal 0',
        ]);

        AnggotaDpr::create($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    // Menampilkan form edit anggota (UPDATE - Form)
    public function edit($id)
    {
        $anggota = AnggotaDpr::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    // Mengupdate data anggota (UPDATE - Store)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'status_pernikahan' => 'required|in:Kawin,Belum Kawin',
            'jumlah_anak' => 'required|integer|min:0',
        ], [
            'nama_depan.required' => 'Nama depan wajib diisi',
            'jabatan.required' => 'Jabatan wajib dipilih',
            'status_pernikahan.required' => 'Status pernikahan wajib dipilih',
            'jumlah_anak.required' => 'Jumlah anak wajib diisi',
            'jumlah_anak.integer' => 'Jumlah anak harus berupa angka',
            'jumlah_anak.min' => 'Jumlah anak minimal 0',
        ]);

        $anggota = AnggotaDpr::findOrFail($id);
        $anggota->update($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    // Menghapus data anggota (DELETE)
    public function destroy($id)
    {
        try {
            $anggota = AnggotaDpr::findOrFail($id);
            
            // Hapus data penggajian terkait terlebih dahulu
            $anggota->penggajian()->delete();
            
            // Baru kemudian hapus data anggota
            $anggota->delete();

            return redirect()->route('anggota.index')
                ->with('success', 'Data anggota berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('anggota.index')
                ->with('error', 'Gagal menghapus data anggota. ' . $e->getMessage());
        }
    }
}