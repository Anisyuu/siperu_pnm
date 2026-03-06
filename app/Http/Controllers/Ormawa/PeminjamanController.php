<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function ajukanPeminjaman()
    {
        return view('layouts.ormawa.peminjaman.ajukan_peminjaman');
    }
}
