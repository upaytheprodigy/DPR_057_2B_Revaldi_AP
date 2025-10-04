<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = 'id_penggajian';

    public function anggota()
    {
        return $this->belongsTo(AnggotaDpr::class, 'id_anggota', 'id_anggota');
    }
}
