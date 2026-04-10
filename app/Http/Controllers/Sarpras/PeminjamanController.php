<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;


class PeminjamanController extends Controller
{
        public function verifikasiPeminjaman(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::with(['ruangan.gedung.kampus', 'pemohon', 'verifikasi' => fn($q) => $q->orderBy('urutan')])
            ->whereDoesntHave('verifikasi', function ($q) use ($userId) {
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

    return view('layouts.sarpras.peminjaman.verifikasi_peminjaman', compact('peminjaman'));
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

        return view('layouts.sarpras.peminjaman.riwayat_verifikasi', compact('peminjaman'));
    }

}
