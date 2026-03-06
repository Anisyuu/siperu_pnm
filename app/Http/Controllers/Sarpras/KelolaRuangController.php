<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelolaRuangController extends Controller
{
    public function KelolaRuang()
    {
        return view('layouts.sarpras.ruangan.kelola_ruangan');
    }
}
