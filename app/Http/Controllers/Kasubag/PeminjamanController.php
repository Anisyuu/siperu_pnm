<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ExportRiwayatCsv;

class PeminjamanController extends Controller
{
    use ExportRiwayatCsv;

    public function verifikasiPeminjaman(Request $request)
    {
        $user = Auth::user();
    $userRoles = $user->roles->pluck('nama')->toArray();

    $jenisPemohonDiizinkan = \DB::table('alur_verifikasi')
        ->whereIn('role_verifikator', $userRoles)
        ->pluck('jenis_pemohon')
        ->toArray();

    $query = Peminjaman::with([
        'ruangan.gedung.kampus',
        'pemohon.roles',
        'verifikasi' => fn ($q) => $q->orderBy('urutan'),
        'verifikasi.verifikator',
        'verifikasiAktif'
    ])
        ->where('status', 'pending')
        ->whereHas('pemohon.roles', function ($q) use ($jenisPemohonDiizinkan) {
            $q->whereIn('nama', $jenisPemohonDiizinkan);
        })
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

    // Ambil ID peminjaman pending paling lama
    $firstPendingId = Peminjaman::where('status', 'pending')
        ->whereHas('pemohon.roles', function ($q) use ($jenisPemohonDiizinkan) {
            $q->whereIn('nama', $jenisPemohonDiizinkan);
        })
        ->whereDoesntHave('verifikasi', function ($q) use ($user) {
            $q->where('id_verifikator', $user->nomor_induk);
        })
        ->oldest()
        ->value('id');

    return view('layouts.kasubag.peminjaman.verifikasi_peminjaman', compact('peminjaman', 'firstPendingId'));
    }

    public function riwayatVerifikasi( Request $request)
    {
        $userId = Auth::user()->nomor_induk;
        $query = Peminjaman::with([
            'ruangan.gedung.kampus',
            'pemohon.roles',
            'verifikasi' => fn ($q) => $q->orderBy('urutan'),
            'verifikasi.verifikator',
        ])
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
            'pemohon.roles',
            'verifikasi' => fn ($q) => $q->orderBy('urutan'),
            'verifikasi.verifikator',
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

    public function exportRiwayatVerifikasi(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::query()
            ->with([
                'ruangan.gedung.kampus',
                'pemohon',
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
            ])
            ->whereHas('verifikasi', function ($q) use ($userId) {
                $q->where('id_verifikator', '=', $userId);
            });

        $this->applyRiwayatFilters($query, $request);

        $peminjaman = $query->latest()->get();

        $fileName = 'riwayat-verifikasi-kasubag-' . now()->format('Ymd_His') . '.csv';

        return $this->downloadRiwayatCsv($peminjaman, $fileName, $userId);
    }

    public function exportRiwayatPeminjaman(Request $request)
    {
        $query = Peminjaman::query()
            ->with([
                'ruangan.gedung.kampus',
                'pemohon',
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
            ]);

        $this->applyRiwayatFilters($query, $request);

        $peminjaman = $query->latest()->get();

        $fileName = 'riwayat-peminjaman-kasubag-' . now()->format('Ymd_His') . '.csv';

        return $this->downloadRiwayatCsv($peminjaman, $fileName);
    }
}
