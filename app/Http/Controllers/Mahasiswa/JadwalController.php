<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function JadwalRuangan()
    {
        return view('layouts.mahasiswa.jadwal.jadwal_ruangan');
    }
}
