<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\AnggotaDpr;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    // Menampilkan daftar penggajian dengan Take Home Pay
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $anggotaTable = (new AnggotaDpr)->getTable();

        $penggajian = AnggotaDpr::select(
            $anggotaTable . '.id_anggota',
            $anggotaTable . '.gelar_depan',
            $anggotaTable . '.nama_depan',
            $anggotaTable . '.nama_belakang',
            $anggotaTable . '.gelar_belakang',
            $anggotaTable . '.jabatan',
            $anggotaTable . '.status_pernikahan',
            $anggotaTable . '.jumlah_anak'
        )
        ->whereHas('penggajian') // Hanya tampilkan anggota yang sudah punya penggajian
        ->when($search, function($query, $search) use ($anggotaTable) {
            return $query->where($anggotaTable . '.nama_depan', 'like', "%{$search}%")
                        ->orWhere($anggotaTable . '.nama_belakang', 'like', "%{$search}%")
                        ->orWhere($anggotaTable . '.jabatan', 'like', "%{$search}%")
                        ->orWhere($anggotaTable . '.id_anggota', 'like', "%{$search}%");
        })
        ->orderBy('id_anggota', 'desc')
        ->paginate(10);
        
        // Hitung Take Home Pay untuk setiap anggota
        foreach ($penggajian as $item) {
            $item->take_home_pay = $item->calculateTakeHomePay();
        }
        
        return view('admin.penggajian.index', compact('penggajian', 'search'));
    }

    // Menampilkan form tambah penggajian
    public function create()
    {
        $anggota = AnggotaDpr::all();
        return view('penggajian.create', compact('anggota'));
    }

    // Get komponen gaji berdasarkan jabatan (AJAX)
    public function getKomponenByJabatan($idAnggota)
    {
        $anggota = AnggotaDpr::findOrFail($idAnggota);
        
        // Ambil komponen yang sesuai dengan jabatan atau "Semua"
        $komponenGaji = KomponenGaji::where(function($query) use ($anggota) {
            $query->where('jabatan', $anggota->jabatan)
                ->orWhere('jabatan', 'Semua');
        })->get();
        
        // Ambil komponen yang sudah ditambahkan untuk anggota ini
        $komponenTerpilih = Penggajian::where('id_anggota', $idAnggota)
            ->pluck('id_komponen_gaji') // Ubah ke id_komponen_gaji
            ->toArray();
        
        return response()->json([
            'anggota' => $anggota,
            'komponenGaji' => $komponenGaji,
            'komponenTerpilih' => $komponenTerpilih,
        ]);
    }

    // Menyimpan data penggajian
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota_dpr,id_anggota',
            'id_komponen' => 'required|array|min:1',
            'id_komponen.*' => 'exists:komponen_gaji,id_komponen_gaji',
        ], [
            'id_anggota.required' => 'Anggota wajib dipilih',
            'id_komponen.required' => 'Minimal pilih 1 komponen gaji',
            'id_komponen.min' => 'Minimal pilih 1 komponen gaji',
        ]);

        $anggota = AnggotaDpr::findOrFail($request->id_anggota);
        
        // Validasi: Cek apakah komponen sudah ada
        foreach ($request->id_komponen as $idKomponen) {
            $exists = Penggajian::where('id_anggota', $request->id_anggota)
                ->where('id_komponen', $idKomponen)
                ->exists();
            
            if ($exists) {
                $komponen = KomponenGaji::find($idKomponen);
                return back()->withErrors([
                    'id_komponen' => "Komponen '{$komponen->nama_komponen}' sudah ditambahkan untuk anggota ini."
                ])->withInput();
            }
            
            // Validasi: Cek apakah komponen sesuai jabatan
            $komponen = KomponenGaji::find($idKomponen);
            if ($komponen->jabatan != 'Semua' && $komponen->jabatan != $anggota->jabatan) {
                return back()->withErrors([
                    'id_komponen' => "Komponen '{$komponen->nama_komponen}' tidak sesuai dengan jabatan {$anggota->jabatan}."
                ])->withInput();
            }
        }

        // Simpan data penggajian
        foreach ($request->id_komponen as $idKomponen) {
            Penggajian::create([
                'id_anggota' => $request->id_anggota,
                'id_komponen' => $idKomponen,
            ]);
        }

        return redirect()->route('admin.penggajian.index')->with('success', 'Data penggajian berhasil ditambahkan!');
    }

    // Menampilkan detail penggajian
    public function show($idAnggota)
    {
        $anggota = AnggotaDpr::with(['penggajian.komponen'])->findOrFail($idAnggota);
        $takeHomePay = $anggota->calculateTakeHomePay();

        return view('admin.penggajian.show', compact('anggota', 'takeHomePay'));
    }

    // Menampilkan form edit penggajian
    public function edit($idAnggota)
    {
        $anggota = AnggotaDpr::with(['penggajian'])->findOrFail($idAnggota);
        
        // Ambil semua komponen yang sesuai jabatan
        $komponenGaji = KomponenGaji::where('jabatan', $anggota->jabatan)
                                    ->orWhere('jabatan', 'Semua')
                                    ->orderBy('nama_komponen')
                                    ->get();
        
        // Ambil komponen yang sudah dipilih
    $komponenTerpilih = $anggota->penggajian->pluck('id_komponen')->toArray();

        return view('admin.penggajian.edit', compact('anggota', 'komponenGaji', 'komponenTerpilih'));
    }

    // Mengupdate data penggajian
    public function update(Request $request, $idAnggota)
    {
        $request->validate([
            'id_komponen' => 'required|array|min:1',
            'id_komponen.*' => 'exists:komponen_gaji,id_komponen_gaji', // Sudah benar
        ], [
            'id_komponen.required' => 'Minimal pilih 1 komponen gaji',
            'id_komponen.min' => 'Minimal pilih 1 komponen gaji',
        ]);

        $anggota = AnggotaDpr::findOrFail($idAnggota);
        
        // Validasi: Cek apakah komponen sesuai jabatan
        foreach ($request->id_komponen as $idKomponen) {
            $komponen = KomponenGaji::find($idKomponen);
            if ($komponen->jabatan != 'Semua' && $komponen->jabatan != $anggota->jabatan) {
                return back()->withErrors([
                    'id_komponen' => "Komponen '{$komponen->nama_komponen}' tidak sesuai dengan jabatan {$anggota->jabatan}."
                ])->withInput();
            }
        }

        // Hapus penggajian lama
        Penggajian::where('id_anggota', $idAnggota)->delete();
        
        // Simpan penggajian baru
        foreach ($request->id_komponen as $idKomponen) {
            Penggajian::create([
                'id_anggota' => $idAnggota,
                'id_komponen_gaji' => $idKomponen, // Sudah benar
            ]);
        }

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil diperbarui!');
    }

    // Menghapus data penggajian
    public function destroy($idAnggota)
    {
        Penggajian::where('id_anggota', $idAnggota)->delete();
        
        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil dihapus!');
    }
}