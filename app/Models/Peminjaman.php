<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
protected $table = 'peminjaman';

    protected $fillable = [
        'no_peminjaman',
        'pemohon_id',
        'ruangan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'kegiatan',
        'dokumen_bukti',
        'status',
        'catatan',
    ];

        // Relasi ke user pemohon
    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id', 'nomor_induk');
    }

    // Relasi ke ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    // Relasi ke langkah-langkah verifikasi
    public function verifikasi()
    {
        return $this->hasMany(Verifikasi::class, 'id_peminjaman')->orderBy('urutan');
    }

    // Langkah verifikasi yang sedang aktif (pending pertama)
    public function verifikasiAktif()
    {
        return $this->hasOne(Verifikasi::class, 'id_peminjaman')
            ->where('status_verifikasi', 'pending')
            ->orderBy('urutan');
    }

   public function isBisaDiAksi($collection)
    {
        $first = $collection
            ->where('status', 'pending')
            ->first();

        return $first && $first->id === $this->id;
    }
}
