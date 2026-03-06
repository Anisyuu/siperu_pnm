<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function jadwalRuangan()
    {
        return view('layouts.dosen.jadwal.jadwal_ruangan');
    }
}
