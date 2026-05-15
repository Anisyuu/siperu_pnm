<?php

namespace App\Http\Controllers\Kalab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman(Request $request)
    {
        $user      = Auth::user();
        $userRoles = $user->roles->pluck('nama')->toArray();

        Log::debug('[verifikasiPeminjaman]', [
            'user'       => $user->nomor_induk,
            'userRoles'  => $userRoles,
        ]);

        // ── 1. Ambil jenis_pemohon yang boleh diverifikasi role ini ──
        $jenisPemohonDiizinkan = \DB::table('alur_verifikasi')
            ->whereIn('role_verifikator', $userRoles)
            ->pluck('jenis_pemohon')
            ->unique()
            ->toArray();

        Log::debug('[verifikasiPeminjaman] jenisPemohonDiizinkan', $jenisPemohonDiizinkan);

        if (empty($jenisPemohonDiizinkan)) {
            // Tidak ada alur yang cocok → tampilkan kosong
            $peminjaman    = Peminjaman::paginate(5);
            $firstPendingId = null;
            return view('layouts.kalab.peminjaman.verifikasi_peminjaman',
                compact('peminjaman', 'firstPendingId'));
        }

        // ── 2. Base query ────────────────────────────────────────────
        $baseQuery = Peminjaman::with([
                'ruangan.gedung.kampus',
                'ruangan.jenisRuangan', // pastikan relasi ini ada
                'pemohon.roles',
                'verifikasi',
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
            //    Jika kalab hanya boleh lihat ruangan lab miliknya,
            //    tambahkan kondisi ini. Jika tidak perlu filter gedung, hapus blok ini.
            $isKalab = in_array('kalab', array_map('strtolower', $userRoles));

            if ($isKalab) {
                // Kalab hanya lihat peminjaman ruangan lab yang ia kelola (id_user = nomor_induk kalab)
                $baseQuery->whereHas('ruangan', function ($q) use ($user) {
                    $q->where('id_user', $user->nomor_induk)
                    ->whereHas('jenisRuangan', function ($q2) {
                        $q2->whereRaw("LOWER(nama) LIKE '%lab%'");
                    });
                });
            }

            // dd($baseQuery->toSql(), $baseQuery->getBindings(), $isKalab);

            // Jika kalab juga punya relasi ke ruangan/gedung tertentu,
            // tambahkan filter di sini. Contoh jika kalab punya id_ruangan:
            // $ruanganIds = Ruangan::where('id_user', $user->nomor_induk)->pluck('id');
            // $baseQuery->whereIn('id_ruangan', $ruanganIds);


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
            $peminjaman = (clone $baseQuery)->oldest()->paginate(5)->withQueryString();

            Log::debug('[verifikasiPeminjaman] total ditemukan', [
                'count' => $peminjaman->total(),
            ]);

            $firstPendingId = (clone $baseQuery)->oldest()->value('id');

            return view('layouts.kalab.peminjaman.verifikasi_peminjaman',
                compact('peminjaman', 'firstPendingId'));
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

        return view('layouts.kalab.peminjaman.riwayat_verifikasi', compact('peminjaman'));
    }
}
