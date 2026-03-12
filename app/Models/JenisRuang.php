<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisRuang extends Model
{
    protected $table = 'jenis_ruang';

    protected $fillable = [
        'nama',
        'slug',
    ];

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_jenis_ruang');
    }

}
