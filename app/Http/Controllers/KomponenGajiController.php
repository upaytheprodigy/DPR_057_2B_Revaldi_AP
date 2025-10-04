<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $komponengajis = KomponenGaji::all();
        return view('admin.komponen_gaji.index', compact('komponengajis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.komponen_gaji.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'kategori' => 'required|string|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|string|in:Ketua,Anggota,Wakil Ketua',
            'nominal' => 'required|numeric',
            'satuan' => 'required|string|in:Bulan,Periode',
        ]);

        KomponenGaji::create($request->all());

        return redirect()->route('komponen-gaji.index')
                         ->with('success', 'Komponen Gaji created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomponenGaji $komponenGaji)
    {
        return view('admin.komponen_gaji.edit', compact('komponenGaji'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KomponenGaji $komponenGaji)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'kategori' => 'required|string|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|string|in:Ketua,Anggota,Wakil Ketua',
            'nominal' => 'required|numeric',
            'satuan' => 'required|string|in:Bulan,Periode',
        ]);

        $komponenGaji->update($request->all());

        return redirect()->route('komponen-gaji.index')
                         ->with('success', 'Komponen Gaji updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomponenGaji $komponenGaji)
    {
        $komponenGaji->delete();

        return redirect()->route('komponen-gaji.index')
                         ->with('success', 'Komponen Gaji deleted successfully.');
    }
}
