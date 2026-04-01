<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung.kampus', 'pemohon']);

    // SEARCH
    if ($request->filled('search')) {
        $query->where('kegiatan', 'like', '%' . $request->search . '%');
    }

    // FILTER STATUS
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $peminjaman = $query->latest()->paginate(5);

    return view('layouts.pimpinan.peminjaman.verifikasi_peminjaman', compact('peminjaman'));
    }

    public function riwayatVerifikasi()
    {
        return view('layouts.pimpinan.peminjaman.riwayat_verifikasi');
    }
}
