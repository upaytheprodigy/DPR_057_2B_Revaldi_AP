<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';
    protected $fillable = [
        'id_komponen_gaji',
        'id_anggota',
    ];

    public $timestamps = false;

    public function anggota()
    {
        return $this->belongsTo(AnggotaDpr::class, 'id_anggota', 'id_anggota');
    }

        public function komponenGaji()
        {
            return $this->belongsTo(KomponenGaji::class, 'id_komponen_gaji', 'id_komponen_gaji');
        }
}
