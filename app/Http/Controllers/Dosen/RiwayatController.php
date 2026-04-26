<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

class RiwayatController extends Controller
{
    public function riwayatPeminjaman()
    {
        return view('layouts.dosen.riwayat.riwayat_peminjaman');
    }
}
