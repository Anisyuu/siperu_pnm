<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function jadwalRuangan()
    {
        return view('layouts.kasubag.jadwal.jadwal_ruangan');
    }
}
