<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function RiwayatPeminjaman()
    {
        return view('layouts.mahasiswa.riwayat.riwayat_peminjaman');
    }
}
