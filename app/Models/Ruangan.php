<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';

    protected $fillable = [
        'id_jenis_ruang',
        'id_gedung',
        'lantai',
        'nomor_ruang',
        'nama_ruang',
        'slug',
    ];


    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'ruangan_id');
    }

    public function jenisRuangan()
    {
        return $this->belongsTo(JenisRuang::class, 'id_jenis_ruang');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }
}
