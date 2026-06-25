<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Gedung;
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

        // Ambil ID gedung milik sarpras ini
        $gedungIds = Gedung::query()
            ->where('id_user', '=', $user->nomor_induk)
            ->pluck('id')
            ->toArray();

        // Ambil jenis_pemohon yang boleh diverifikasi oleh role ini
        $jenisPemohonDiizinkan = DB::table('alur_verifikasi')
            ->whereIn('role_verifikator', $userRoles)
            ->pluck('jenis_pemohon')
            ->toArray();

       $query = Peminjaman::with([
                'ruangan.gedung.kampus',
                'pemohon.roles',
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
                'verifikasi.verifikator',
                'verifikasiAktif',
            ])
            ->where('status', '=', 'pending')

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
                $q->where('id_verifikator', '=', $user->nomor_induk);
            });

        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', '=', $request->status);
        }

        $peminjaman = $query->oldest()->paginate(5)->withQueryString();

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
                $q->where('id_verifikator', '=', $user->nomor_induk);
            })
            ->oldest()
            ->value('id');

        return view('layouts.sarpras.peminjaman.verifikasi_peminjaman', compact(
            'peminjaman',
            'firstPendingId'
        ));
    }

    public function riwayatVerifikasi(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::with([
                'ruangan.gedung.kampus',
                'pemohon.roles',
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
                'verifikasi.verifikator',
            ])
            ->whereHas('verifikasi', function ($q) use ($userId) {
                $q->where('id_verifikator', '=', $userId);
            });

        $this->applyRiwayatFilters($query, $request);

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('layouts.sarpras.peminjaman.riwayat_verifikasi', compact('peminjaman'));
    }

    public function exportRiwayatVerifikasi(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::query()
            ->with([
                'ruangan.gedung.kampus',
                'pemohon.roles',
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
            ])
            ->whereHas('verifikasi', function ($q) use ($userId) {
                $q->where('id_verifikator', '=', $userId);
            });

        $this->applyRiwayatFilters($query, $request);

        // Export harus get(), bukan paginate()
        $peminjaman = $query->latest()->get();

        $fileName = 'riwayat-verifikasi-sarpras-' . now()->format('Ymd_His') . '.csv';

        return $this->downloadRiwayatCsv($peminjaman, $fileName, $userId);
    }
}
