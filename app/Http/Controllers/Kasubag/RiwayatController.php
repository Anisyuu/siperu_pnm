<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayatVerifikasi()
    {
        return view('layouts.kasubag.riwayat.riwayat_verifikasi');
    }

    public function riwayatPeminjaman()
    {
        return view('layouts.kasubag.riwayat.riwayat_peminjaman');
    }
}
