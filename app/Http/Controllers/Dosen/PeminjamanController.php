<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function ajukanPeminjaman()
    {
        return view('layouts.dosen.peminjaman.ajukan_peminjaman');
    }
}
