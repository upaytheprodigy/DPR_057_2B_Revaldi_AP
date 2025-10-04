<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\AnggotaDpr;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::with(['anggota', 'komponenGaji'])->get();
        return view('admin.penggajian.index', compact('penggajians'));
    }

    public function create()
    {
        $anggotas = AnggotaDpr::all();
        $komponens = KomponenGaji::all();
        return view('admin.penggajian.create', compact('anggotas', 'komponens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_komponen_gaji' => 'required|exists:komponen_gaji,id_komponen_gaji',
        ]);

    Penggajian::create($request->only(['id_komponen_gaji', 'id_anggota']));

        return redirect()->route('penggajian.index')
                         ->with('success', 'Data penggajian berhasil ditambahkan.');
    }

    public function edit($id_komponen_gaji, $id_anggota)
    {
        $penggajian = Penggajian::where('id_komponen_gaji', $id_komponen_gaji)
            ->where('id_anggota', $id_anggota)
            ->firstOrFail();
        $anggotas = AnggotaDpr::all();
        $komponens = KomponenGaji::all();
        return view('admin.penggajian.edit', compact('penggajian', 'anggotas', 'komponens'));
    }

    public function update(Request $request, $id_komponen_gaji, $id_anggota)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_komponen_gaji' => 'required|exists:komponen_gaji,id_komponen_gaji',
        ]);
        Penggajian::where('id_komponen_gaji', $id_komponen_gaji)
            ->where('id_anggota', $id_anggota)
            ->update($request->only(['id_komponen_gaji', 'id_anggota']));
        return redirect()->route('penggajian.index')
                         ->with('success', 'Data penggajian berhasil diperbarui.');
    }

    public function destroy($id_komponen_gaji, $id_anggota)
    {
        Penggajian::where('id_komponen_gaji', $id_komponen_gaji)
            ->where('id_anggota', $id_anggota)
            ->delete();
        return redirect()->route('penggajian.index')
                         ->with('success', 'Data penggajian berhasil dihapus.');
    }

    public function getKomponenByAnggota(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $anggota = AnggotaDpr::find($id_anggota);

        if (!$anggota) {
            return response()->json([]);
        }

        $komponens = KomponenGaji::where('jabatan', $anggota->jabatan)->get();
        return response()->json($komponens);
    }
}
