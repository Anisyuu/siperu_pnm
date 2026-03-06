<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman()
    {
        return view('layouts.pimpinan.peminjaman.verifikasi_peminjaman');
    }

    public function riwayatVerifikasi()
    {
        return view('layouts.pimpinan.peminjaman.riwayat_verifikasi');
    }
}
