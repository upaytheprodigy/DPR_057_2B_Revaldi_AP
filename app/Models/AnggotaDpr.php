<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaDpr extends Model
{
    protected $table = 'anggota';
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

    // Fix the table name in the relationship
    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'id_anggota', 'id_anggota')
                    ->from('penggajian'); // Specify the correct table name
    }
}