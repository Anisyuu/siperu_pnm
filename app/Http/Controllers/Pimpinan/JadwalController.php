<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function jadwalRuangan()
    {
        return view('layouts.pimpinan.jadwal.jadwal_ruangan');
    }
}
