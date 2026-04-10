<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::with([
            'ruangan.gedung.kampus',
            'pemohon',
            'verifikasi' => fn($q) => $q->orderBy('urutan')
        ]);


        // SEARCH
        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->oldest()->paginate(5);

        return view('layouts.kasubag.peminjaman.verifikasi_peminjaman', compact('peminjaman'));
    }

    public function riwayatVerifikasi( Request $request)
    {
        $userId = Auth::user()->nomor_induk;
        $query = Peminjaman::with(['ruangan.gedung.kampus', 'pemohon', 'verifikasi' => fn($q) => $q->orderBy('urutan')])
            ->whereHas('verifikasi', function ($q) use ($userId) {
                $q->where('id_verifikator', $userId);
            });

            // SEARCH
        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5);

        return view('layouts.kasubag.riwayat.riwayat_verifikasi', compact('peminjaman'));
    }

    public function riwayatPeminjaman(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::with([
            'ruangan.gedung.kampus',
            'pemohon',
            'verifikasi' => fn($q) => $q->orderBy('urutan')
        ]);

        // SEARCH
        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5);

        return view('layouts.kasubag.riwayat.riwayat_peminjaman', compact('peminjaman'));
    }
}
