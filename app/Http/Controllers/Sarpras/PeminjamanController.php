<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman(Request $request)
{
    $user      = Auth::user();
    $userRoles = $user->roles->pluck('nama')->toArray();

    // Ambil ID gedung milik sarpras ini
    $gedungIds = \App\Models\Gedung::query()
                ->where('id_user', '=', $user->nomor_induk)
                ->pluck('id')
                ->toArray();

    // Ambil jenis_pemohon yang boleh diverifikasi oleh role ini
    // (dipindah ke luar query agar tidak ada nested closure)
    $jenisPemohonDiizinkan = DB::table('alur_verifikasi')
                    ->whereIn('role_verifikator', $userRoles)
                    ->pluck('jenis_pemohon')
                    ->toArray();

    $query = Peminjaman::with([
            'ruangan.gedung.kampus',
            'pemohon.roles',
            'verifikasi',
            'verifikasiAktif',
        ])
        ->where('status', 'pending')

        // Hanya ruangan di gedung milik sarpras ini
        ->whereHas('ruangan', function ($q) use ($gedungIds) {
            $q->whereIn('id_gedung', $gedungIds);
        })

        // Jenis pemohon sesuai alur verifikasi role ini
        ->whereHas('pemohon.roles', function ($q) use ($jenisPemohonDiizinkan) {
            $q->whereIn('nama', $jenisPemohonDiizinkan);
        })

        // Belum diverifikasi oleh user ini
        ->whereDoesntHave('verifikasi', function ($q) use ($user) {
            $q->where('id_verifikator', $user->nomor_induk);
        });

    if ($request->filled('search')) {
        $query->where('kegiatan', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $peminjaman = $query->oldest()->paginate(5);

    // ID peminjaman pending paling lama di gedung ini
    $firstPendingId = Peminjaman::query()
        ->where('status', '=', 'pending')
        ->whereHas('ruangan', function ($q) use ($gedungIds) {
            $q->whereIn('id_gedung', $gedungIds);
        })

        ->whereHas('pemohon.roles', function ($q) use ($jenisPemohonDiizinkan) {
        $q->whereIn('nama', $jenisPemohonDiizinkan);
        })

        ->whereDoesntHave('verifikasi', function ($q) use ($user) {
            $q->where('id_verifikator', $user->nomor_induk);
        })
        ->oldest()
        ->value('id');

    return view('layouts.sarpras.peminjaman.verifikasi_peminjaman', compact('peminjaman', 'firstPendingId'));
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
