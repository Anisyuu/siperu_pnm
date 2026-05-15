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
        'nama_ruang',
        "id_user",
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

    public function user()
    {
        return $this->belongsTo(User::class,'id_user','nomor_induk');
    }

}
