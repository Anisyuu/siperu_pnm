<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';

    protected $fillable = [
        'nama',
        'id_user',
        'kampus_id',
        'lantai',
        'slug',
    ];

    public function getRoutekeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user','nomor_induk');
    }

    public function kampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_gedung');
    }

    /** Shortcut: ruangan di lantai tertentu */
    public function ruanganDiLantai(int $lantai)
    {
        return $this->ruangan()->where('lantai', $lantai);
    }
}
