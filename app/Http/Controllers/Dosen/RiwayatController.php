<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Kampus;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RiwayatController extends Controller
{
    public function riwayatPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung'])
            ->where('pemohon_id', Auth::user()->nomor_induk)
            ->whereIn('status', ['disetujui', 'ditolak']); // hanya riwayat (bukan pending)

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.dosen.riwayat.riwayat_peminjaman', compact('peminjaman'));
    }
}
