<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Kampus;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function listPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk);

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.ormawa.peminjaman.list_peminjaman', compact('peminjaman'));
    }

    public function ajukanPeminjaman()
    {
        $kampus = Kampus::orderBy('nama_kampus')->get();

    $gedung = Gedung::with('kampus')
        ->orderBy('nama')
        ->get();

    $ruangan = Ruangan::with(['gedung.kampus'])
        ->orderBy('nama_ruang')
        ->get();

    return view('layouts.ormawa.peminjaman.ajukan_peminjaman', compact(
        'kampus',
        'gedung',
        'ruangan'
    ));
    }
}
