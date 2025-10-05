<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    // Menampilkan daftar komponen gaji
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $komponenGaji = KomponenGaji::when($search, function($query, $search) {
            return $query->where('id_komponen_gaji', 'like', "%{$search}%")
                        ->orWhere('nama_komponen', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%")
                        ->orWhere('jabatan', 'like', "%{$search}%")
                        ->orWhere('nominal', 'like', "%{$search}%")
                        ->orWhere('satuan', 'like', "%{$search}%");
        })->orderBy('id_komponen_gaji', 'asc')->paginate(10);
        
        return view('admin.komponen_gaji.index', compact('komponenGaji', 'search'));
    }

    // Menampilkan form tambah komponen gaji
    public function create()
    {
        return view('admin.komponen_gaji.create');
    }

    // Menyimpan data komponen gaji
    public function store(Request $request)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'kategori' => 'required|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota,Semua',
            'nominal' => 'required|numeric|min:0',
            'satuan' => 'required|in:Bulan,Hari,Periode',
        ], [
            'nama_komponen.required' => 'Nama komponen wajib diisi',
            'kategori.required' => 'Kategori wajib diisi',
            'jabatan.required' => 'Jabatan wajib dipilih',
            'nominal.required' => 'Nominal wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'satuan.required' => 'Satuan wajib dipilih',
        ]);

        KomponenGaji::create($request->all());

        return redirect()->route('komponen-gaji.index')->with('success', 'Komponen gaji berhasil ditambahkan!');
    }

    // Menampilkan form edit komponen gaji
    public function edit($id)
    {
        $komponen = KomponenGaji::findOrFail($id);
        return view('admin.komponen_gaji.edit', compact('komponen'));
    }

    // Mengupdate data komponen gaji
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'kategori' => 'required|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota,Semua',
            'nominal' => 'required|numeric|min:0',
            'satuan' => 'required|in:Bulan,Hari,Periode',
        ]);

        $komponen = KomponenGaji::findOrFail($id);
        $komponen->update($request->all());

        return redirect()->route('komponen-gaji.index')->with('success', 'Komponen gaji berhasil diperbarui!');
    }

    // Menghapus data komponen gaji
    public function destroy($id)
    {
        $komponen = KomponenGaji::findOrFail($id);
        $komponen->delete();

        return redirect()->route('komponen-gaji.index')->with('success', 'Komponen gaji berhasil dihapus!');
    }
}