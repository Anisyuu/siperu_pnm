<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'ruangan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'kegiatan',
        'penanggung_jawab',
        'catatan',
    ];

    protected static function booted(): void
    {
        static::saving(function (Jadwal $jadwal) {
            // Otomatis isi hari berdasarkan tanggal
            if (!empty($jadwal->tanggal)) {
                $jadwal->hari = Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('l');
            }
        });
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
