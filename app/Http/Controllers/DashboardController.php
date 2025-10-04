<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnggotaDpr;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik untuk dashboard
        $totalAnggota = AnggotaDpr::count();
        $totalKetua = AnggotaDpr::where('jabatan', 'Ketua')->count();
        $totalWakilKetua = AnggotaDpr::where('jabatan', 'Wakil Ketua')->count();
        $totalAnggotaBiasa = AnggotaDpr::where('jabatan', 'Anggota')->count();
        
        return view('dashboard', compact(
            'totalAnggota',
            'totalKetua',
            'totalWakilKetua',
            'totalAnggotaBiasa'
        ));
    }
}