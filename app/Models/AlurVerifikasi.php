<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlurVerifikasi extends Model
{
    //
    protected $table = 'alur_verifikasi';
    protected $fillable = [
        'jenis_pemohon',
        'urutan',
        'role_verifikator',
    ];
}
