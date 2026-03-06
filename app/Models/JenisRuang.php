<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisRuang extends Model
{
    protected $table = 'jenis_ruang';

    protected $fillable = [
        'nama',
    ];

}
