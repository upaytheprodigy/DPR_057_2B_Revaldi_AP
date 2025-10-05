<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = 'id_penggajian';
    public $timestamps = false;
    
    protected $fillable = [
        'id_anggota',
        'id_komponen_gaji',
    ];

    // Relasi ke AnggotaDpr
    public function anggota()
    {
        return $this->belongsTo(AnggotaDpr::class, 'id_anggota', 'id_anggota');
    }

    // Relasi ke KomponenGaji
    public function komponen()
    {
        return $this->belongsTo(KomponenGaji::class, 'id_komponen_gaji', 'id_komponen_gaji');
    }
}