<?php

namespace App\Http\Controllers\Kalab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\ExportRiwayatCsv;

class PeminjamanController extends Controller
{
    use ExportRiwayatCsv;

    public function verifikasiPeminjaman(Request $request)
    {
        $user      = Auth::user();
        $userRoles = $user->roles->pluck('nama')->toArray();

        Log::debug('[verifikasiPeminjaman]', [
            'user'      => $user->nomor_induk,
            'userRoles' => $userRoles,
        ]);

        // ── 1. Ambil jenis_pemohon yang boleh diverifikasi role ini ──
        $jenisPemohonDiizinkan = DB::table('alur_verifikasi')
            ->whereIn('role_verifikator', $userRoles)
            ->pluck('jenis_pemohon')
            ->unique()
            ->toArray();

        Log::debug('[verifikasiPeminjaman] jenisPemohonDiizinkan', $jenisPemohonDiizinkan);

        if (empty($jenisPemohonDiizinkan)) {
            // Tidak ada alur yang cocok → tampilkan kosong
            $peminjaman = Peminjaman::whereRaw('1 = 0')->paginate(5);
            $firstPendingId = null;

            return view(
                'layouts.kalab.peminjaman.verifikasi_peminjaman',
                compact('peminjaman', 'firstPendingId')
            );
        }

        // ── 2. Base query ────────────────────────────────────────────
        $baseQuery = Peminjaman::with([
                'ruangan.gedung.kampus',
                'ruangan.jenisRuangan',
                'pemohon.roles',

                // DIBENAHI:
                // verifikasi harus diurutkan dan relasi verifikator harus dibawa
                // supaya Blade bisa menampilkan nama user yang melakukan verifikasi.
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
                'verifikasi.verifikator',

                'verifikasiAktif',
            ])
            ->where('status', 'pending')

            // Jenis pemohon sesuai alur verifikasi role ini
            ->whereHas('pemohon.roles', function ($q) use ($jenisPemohonDiizinkan) {
                $q->whereIn('nama', $jenisPemohonDiizinkan);
            })

            // Belum pernah disetujui/ditolak oleh user ini di step manapun
            ->whereDoesntHave('verifikasi', function ($q) use ($user) {
                $q->where('id_verifikator', $user->nomor_induk)
                    ->whereIn('status_verifikasi', ['disetujui', 'ditolak']);
            });

        // ── 3. Filter kalab: hanya ruangan Lab yang ia kelola ────────
        $isKalab = in_array('kalab', array_map('strtolower', $userRoles));

        if ($isKalab) {
            // Kalab hanya lihat peminjaman ruangan lab yang ia kelola
            $baseQuery->whereHas('ruangan', function ($q) use ($user) {
                $q->where('id_user', $user->nomor_induk)
                    ->whereHas('jenisRuangan', function ($q2) {
                        $q2->whereRaw("LOWER(nama) LIKE '%lab%'");
                    });
            });
        }

        // ── 4. Filter search & status ────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;

            $baseQuery->where(function ($q) use ($search) {
                $q->where('kegiatan', 'like', "%{$search}%")
                    ->orWhere('no_peminjaman', 'like', "%{$search}%")
                    ->orWhereHas('pemohon', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        // ── 5. Eksekusi ───────────────────────────────────────────────
        $peminjaman = (clone $baseQuery)
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        Log::debug('[verifikasiPeminjaman] total ditemukan', [
            'count' => $peminjaman->total(),
        ]);

        $firstPendingId = (clone $baseQuery)
            ->oldest()
            ->value('id');

        return view(
            'layouts.kalab.peminjaman.verifikasi_peminjaman',
            compact('peminjaman', 'firstPendingId')
        );
    }

    public function riwayatVerifikasi(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::with([
                'ruangan.gedung.kampus',
                'pemohon.roles',

                // DIBENAHI:
                // supaya riwayat verifikasi juga bisa menampilkan
                // nama user verifikator di alur verifikasi.
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

        $peminjaman = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'layouts.kalab.peminjaman.riwayat_verifikasi',
            compact('peminjaman')
        );
    }

    public function exportRiwayatVerifikasi(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $query = Peminjaman::query()
            ->with([
                'ruangan.gedung.kampus',
                'pemohon.roles',

                // DIBENAHI:
                // aman ditambahkan juga untuk kebutuhan export,
                // terutama kalau trait export membaca data verifikator.
                'verifikasi' => fn ($q) => $q->orderBy('urutan'),
                'verifikasi.verifikator',
            ])
            ->whereHas('verifikasi', function ($q) use ($userId) {
                $q->where('id_verifikator', '=', $userId);
            });

        $this->applyRiwayatFilters($query, $request);

        $peminjaman = $query->latest()->get();

        $fileName = 'riwayat-verifikasi-kalab-' . now()->format('Ymd_His') . '.csv';

        return $this->downloadRiwayatCsv($peminjaman, $fileName, $userId);
    }
}
