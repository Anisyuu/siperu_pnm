<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayatPeminjaman()
    {
        return view('layouts.ormawa.riwayat.riwayat_peminjaman');
    }
}
