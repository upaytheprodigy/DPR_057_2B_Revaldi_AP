<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaDpr extends Model
{
    protected $table = 'anggota'; // PENTING: Pastikan ini benar
    protected $primaryKey = 'id_anggota';
    
    protected $fillable = [
        'gelar_depan',
        'nama_depan',
        'nama_belakang',
        'gelar_belakang',
        'jabatan',
        'status_pernikahan',
        'jumlah_anak',
    ];

    // Relasi ke Penggajian
    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'id_anggota', 'id_anggota');
    }

    // Method untuk menghitung Take Home Pay
    public function calculateTakeHomePay()
    {
        $penggajian = $this->penggajian;
        
        $totalBulanan = 0;
        $totalTahunan = 0;
        
        foreach ($penggajian as $item) {
            // Cek dulu apakah komponennya ada sebelum mengakses propertinya
            if ($item->komponen) { 
                $komponen = $item->komponen;
                
                // Skip tunjangan istri/suami jika belum kawin
                if ($komponen->nama_komponen == 'Tunjangan Istri/Suami' && $this->status_pernikahan != 'Kawin') {
                    continue;
                }
                
                // Skip tunjangan anak jika jumlah anak = 0
                if ($komponen->nama_komponen == 'Tunjangan Anak' && $this->jumlah_anak == 0) {
                    continue;
                }
                
                // Hitung tunjangan anak maksimal 2 anak
                $nominal = $komponen->nominal; // Default nominal
                if ($komponen->nama_komponen == 'Tunjangan Anak') {
                    $jumlahAnakDihitung = min($this->jumlah_anak, 2);
                    $nominal = $komponen->nominal * $jumlahAnakDihitung;
                }
                
                // Pisahkan berdasarkan satuan
                if ($komponen->satuan == 'Bulan') {
                    $totalBulanan += $nominal;
                } else {
                    $totalTahunan += $nominal;
                }
            }
        }
        
        return [
            'bulanan' => $totalBulanan,
            'tahunan' => $totalTahunan,
            'total_bulanan' => $totalBulanan,
            'total_tahunan' => ($totalBulanan * 12) + $totalTahunan,
        ];
    }
}