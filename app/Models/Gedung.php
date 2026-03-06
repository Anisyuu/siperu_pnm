<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';

    protected $fillable = [
        'nama',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user','nomor_induk');
    }
}
