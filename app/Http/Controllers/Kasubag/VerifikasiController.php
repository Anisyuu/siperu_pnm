<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Verifikasi;
use App\Models\AlurVerifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerifikasiController extends Controller
{

    private function cekGiliran(Peminjaman $peminjaman): array
    {
        $user     = Auth::user();
        $roleUser = strtolower(trim($user->roles->pluck('nama')->first() ?? $user->role)); // sesuaikan dengan struktur role Anda

        Log::debug('[role]', [
            'role_user'     => $roleUser,
        ]);

        if (!$peminjaman->pemohon) {
            return ['boleh' => false, 'pesan' => 'Data pemohon tidak ditemukan.'];
        }

        // 1. Tentukan jenis_pemohon
        $jenisPemohon = optional($peminjaman->pemohon)
            ->roles
            ->pluck('nama')
            ->map(fn($r) => strtolower(trim($r)))
            ->first();

        if (!$jenisPemohon) {
            return [
                'boleh' => false,
                'pesan' => 'Jenis pemohon tidak dapat ditentukan. '
                         . 'Pastikan kolom role/jenis_pemohon ada di tabel user '
                         . 'dan data alur_verifikasi sudah diisi.',
            ];
        }

        Log::debug('[cekGiliran]', [
            'peminjaman_id' => $peminjaman->id,
            'jenis_pemohon' => $jenisPemohon,
            'role_user'     => $roleUser,
        ]);

        // 2. Ambil alur verifikasi
        $alur = AlurVerifikasi::whereRaw('LOWER(TRIM(jenis_pemohon)) = ?', [$jenisPemohon])
            ->orderBy('urutan')
            ->get();

        if ($alur->isEmpty()) {
            return [
                'boleh' => false,
                'pesan' => "Tidak ada alur verifikasi untuk jenis pemohon '{$jenisPemohon}'. "
                         . 'Buat alur di menu Alur Verifikasi terlebih dahulu.',
            ];
        }

        // 3. Ambil semua record verifikasi yang sudah ada
        $tercatat = Verifikasi::where('id_peminjaman', $peminjaman->id)
            ->get()
            ->keyBy('urutan');

        // 4. Jika ada yang ditolak → stop
        if ($tercatat->contains('status_verifikasi', 'ditolak')) {
            return ['boleh' => false, 'pesan' => 'Peminjaman sudah ditolak sebelumnya.'];
        }

        // 5. Cari step yang sedang giliran
        //    → urutan pertama di alur yang belum 'disetujui'
        $giliranAlur = null;

        foreach ($alur as $step) {
            $record = $tercatat->get($step->urutan);

            if (!$record || $record->status_verifikasi == 'pending') {
                $giliranAlur = $step;
                break;
            }
            // 'disetujui' → lanjut ke urutan berikutnya
        }

        // 6. Semua sudah selesai
        if (!$giliranAlur) {
            return ['boleh' => false, 'pesan' => 'Semua langkah verifikasi sudah selesai.'];
        }

        // 7. Cocokkan role user dengan role giliran
        $roleStep = strtolower(trim($giliranAlur->role_verifikator));

        if ($roleUser !== $roleStep) {
            return [
                'boleh' => false,
                'pesan' => "Belum giliran Anda. "
                         . "Giliran saat ini: '{$roleStep}' (urutan {$giliranAlur->urutan}).",
            ];
        }

        // 8. Jika sudah ada record pending di step ini,
        //    pastikan verifikator-nya adalah user yang sekarang login
        $recordGiliran = $tercatat->get($giliranAlur->urutan);

        if ($recordGiliran
            && !empty($recordGiliran->id_verifikator)
            && $recordGiliran->id_verifikator !== $user->nomor_induk
        ) {
            return [
                'boleh' => false,
                'pesan' => 'Langkah ini sudah diambil oleh verifikator lain.',
            ];
        }

        return [
            'boleh'            => true,
            'urutan'           => $giliranAlur->urutan,
            'role_verifikator' => $giliranAlur->role_verifikator,
            'total_urutan'     => $alur->count(),
            'record_giliran'   => $recordGiliran,
        ];
    }

    // ──────────────────────────────────────────────────────────────
    // APPROVE
    // ──────────────────────────────────────────────────────────────
    public function approve(Request $request, Peminjaman $peminjaman)
    {
        Log::info('=== APPROVE START ===', [
            'peminjaman_id' => $peminjaman->id,
            'status'        => $peminjaman->status,
            'user'          => Auth::user()->nomor_induk,
            'user_role'     => Auth::user()->role,
            'pemohon_attrs' => $peminjaman->pemohon?->getAttributes(), // debug kolom
        ]);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $cek = $this->cekGiliran($peminjaman);
        Log::info('[approve] cekGiliran result', $cek);

        if (!$cek['boleh']) {
            return back()->with('error', $cek['pesan']);
        }

        try {
            DB::transaction(function () use ($peminjaman, $cek) {
                $user    = Auth::user();
                $urutan  = $cek['urutan'];
                $isFinal = ($urutan === $cek['total_urutan']);

                Verifikasi::updateOrCreate(
                    [
                        'id_peminjaman' => $peminjaman->id,
                        'urutan'        => $urutan,
                    ],
                    [
                        'id_verifikator'    => $user->nomor_induk,
                        'role_verifikator'  => $user->roles->pluck('nama')->first() ?? $user->role,
                        'status_verifikasi' => 'disetujui',
                        'waktu_verifikasi'  => now(),
                        'catatan'           => null,
                    ]
                );

                if ($isFinal) {
                    $peminjaman->update(['status' => 'disetujui']);
                }

                Log::info('[approve] berhasil', [
                    'peminjaman_id' => $peminjaman->id,
                    'urutan'        => $urutan,
                    'is_final'      => $isFinal,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('[approve] exception', [
                'message'       => $e->getMessage(),
                'peminjaman_id' => $peminjaman->id,
            ]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $pesan = ($cek['urutan'] === $cek['total_urutan'])
            ? 'Pengajuan disetujui. Semua langkah verifikasi selesai.'
            : "Langkah {$cek['urutan']} dari {$cek['total_urutan']} disetujui. Menunggu verifikasi berikutnya.";

        return back()->with('success', $pesan);
    }

    // ──────────────────────────────────────────────────────────────
    // REJECT
    // ──────────────────────────────────────────────────────────────
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $cek = $this->cekGiliran($peminjaman);
        if (!$cek['boleh']) {
            return back()->with('error', $cek['pesan']);
        }

        try {
            DB::transaction(function () use ($peminjaman, $cek, $request) {
                $user   = Auth::user();
                $urutan = $cek['urutan'];

                Verifikasi::updateOrCreate(
                    [
                        'id_peminjaman' => $peminjaman->id,
                        'urutan'        => $urutan,
                    ],
                    [
                        'id_verifikator'    => $user->nomor_induk,
                        'role_verifikator'  => $user->roles->pluck('nama')->first() ?? $user->role,
                        'status_verifikasi' => 'ditolak',
                        'waktu_verifikasi'  => now(),
                        'catatan'           => $request->catatan,
                    ]
                );

                // Batalkan semua langkah pending lain
                Verifikasi::where('id_peminjaman', $peminjaman->id)
                    ->where('urutan', '!=', $urutan)
                    ->where('status_verifikasi', 'pending')
                    ->update([
                        'status_verifikasi' => 'ditolak',
                        'waktu_verifikasi'  => now(),
                        'catatan'           => "Dibatalkan otomatis karena urutan {$urutan} ditolak.",
                    ]);

                $peminjaman->update([
                    'status'  => 'ditolak',
                    'catatan' => $request->catatan,
                ]);

                Log::info('[reject] berhasil', [
                    'peminjaman_id' => $peminjaman->id,
                    'urutan'        => $urutan,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('[reject] exception', [
                'message'       => $e->getMessage(),
                'peminjaman_id' => $peminjaman->id,
            ]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}