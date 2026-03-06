<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
protected $table = 'peminjaman';

    protected $fillable = [
        'pemohon_id',
        'ruangan_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'kegiatan',
        'dokumen_bukti',
        'status',
        'catatan',
    ];

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
