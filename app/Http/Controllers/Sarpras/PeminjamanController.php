<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman()
    {
        return view('layouts.sarpras.peminjaman.verifikasi_peminjaman');
    }

    public function riwayatVerifikasi()
    {
        return view('layouts.sarpras.peminjaman.riwayat_verifikasi');
    }
}
