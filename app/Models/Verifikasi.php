<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    protected $table = 'verifikasi';
 
    protected $fillable = [
        'id_peminjaman',
        'id_verifikator',
        'urutan',
        'role_verifikator',
        'status_verifikasi',
        'catatan',
        'waktu_verifikasi',
    ];
 
    protected $casts = [
        'waktu_verifikasi' => 'datetime',
    ];
 
    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
 
    // Relasi ke user verifikator
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'id_verifikator', 'nomor_induk');
    }
}
