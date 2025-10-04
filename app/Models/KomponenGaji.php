<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    use HasFactory;

    public $timestamps = false; // Menonaktifkan timestamps

    protected $table = 'komponen_gaji'; // Menentukan nama tabel secara eksplisit

    protected $primaryKey = 'id_komponen_gaji';

    protected $fillable = [
        'nama_komponen',
        'kategori',
        'jabatan',
        'nominal',
        'satuan',
    ];
}
