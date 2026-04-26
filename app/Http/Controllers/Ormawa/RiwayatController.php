<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;

class RiwayatController extends Controller
{
    public function riwayatPeminjaman()
    {
        return view('layouts.ormawa.riwayat.riwayat_peminjaman');
    }
}
