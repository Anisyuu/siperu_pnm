<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman()
    {
        return view('layouts.kasubag.peminjaman.verifikasi_peminjaman');
    }
}
