<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function AjukanPeminjaman()
    {
        return view('layouts.mahasiswa.peminjaman.ajukan_peminjaman');
    }
}
