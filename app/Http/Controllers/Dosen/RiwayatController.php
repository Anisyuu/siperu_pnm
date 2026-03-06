<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayatPeminjaman()
    {
        return view('layouts.dosen.riwayat.riwayat_peminjaman');
    }
}
