<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Verifikasi;
use App\Models\User;
use App\Models\AlurVerifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\PengajuanPeminjamanNotification;
use App\Notifications\VerifikasiPeminjamanNotification;

class VerifikasiController extends Controller
{
    private function cekGiliran(Peminjaman $peminjaman): array
    {
        $user = Auth::user();

        $roleUser = strtolower(trim(
            $user->roles->pluck('nama')->first() ?? $user->role
        ));

        $peminjaman->loadMissing([
            'pemohon.roles',
            'ruangan.jenisRuangan',
        ]);

        if (!$peminjaman->pemohon) {
            return ['boleh' => false, 'pesan' => 'Data pemohon tidak ditemukan.'];
        }

        if (!$peminjaman->ruangan) {
            return ['boleh' => false, 'pesan' => 'Data ruangan tidak ditemukan.'];
        }

        if (!$peminjaman->ruangan->jenisRuangan) {
            return ['boleh' => false, 'pesan' => 'Data jenis ruang tidak ditemukan.'];
        }

        $jenisPemohon = optional($peminjaman->pemohon)
            ->roles
            ->pluck('nama')
            ->map(fn($r) => strtolower(trim($r)))
            ->first();

        if (!$jenisPemohon) {
            return ['boleh' => false, 'pesan' => 'Jenis pemohon tidak dapat ditentukan.'];
        }

        $jenisRuangSlug = strtolower(trim($peminjaman->ruangan->jenisRuangan->slug ?? ''));
        $jenisRuangNama = strtolower(trim($peminjaman->ruangan->jenisRuangan->nama ?? ''));
        $isLab = str_contains($jenisRuangSlug, 'lab') || str_contains($jenisRuangNama, 'lab');

        Log::debug('[cekGiliran]', [
            'peminjaman_id'    => $peminjaman->id,
            'jenis_pemohon'    => $jenisPemohon,
            'jenis_ruang_slug' => $jenisRuangSlug,
            'is_lab'           => $isLab,
            'role_user'        => $roleUser,
        ]);

        $alur = AlurVerifikasi::whereRaw('LOWER(TRIM(jenis_pemohon)) = ?', [$jenisPemohon])
            ->when(!$isLab, fn($q) => $q->whereRaw('LOWER(TRIM(role_verifikator)) != ?', ['kalab']))
            ->orderBy('urutan')
            ->get()
            ->values();

        if ($alur->isEmpty()) {
            return [
                'boleh' => false,
                'pesan' => "Tidak ada alur verifikasi untuk jenis pemohon '{$jenisPemohon}'.",
            ];
        }

        $tercatat = Verifikasi::where('id_peminjaman', $peminjaman->id)
            ->get()
            ->keyBy('urutan');

        if ($tercatat->contains('status_verifikasi', 'ditolak')) {
            return ['boleh' => false, 'pesan' => 'Peminjaman sudah ditolak sebelumnya.'];
        }

        $giliranAlur = null;
        $urutanAktif = null;

        foreach ($alur as $index => $step) {
            $urutanBaru = $index + 1;
            $record = $tercatat->get($urutanBaru);

            if (!$record || $record->status_verifikasi === 'pending') {
                $giliranAlur = $step;
                $urutanAktif = $urutanBaru;
                break;
            }
        }

        if (!$giliranAlur) {
            return ['boleh' => false, 'pesan' => 'Semua langkah verifikasi sudah selesai.'];
        }

        $roleStep = strtolower(trim($giliranAlur->role_verifikator));

        if ($roleUser !== $roleStep) {
            return [
                'boleh' => false,
                'pesan' => "Belum giliran Anda. Giliran saat ini: '{$roleStep}' (urutan {$urutanAktif}).",
            ];
        }

        $recordGiliran = $tercatat->get($urutanAktif);

        if (
            $recordGiliran
            && !empty($recordGiliran->id_verifikator)
            && $recordGiliran->id_verifikator !== $user->nomor_induk
        ) {
            return ['boleh' => false, 'pesan' => 'Langkah ini sudah diambil oleh verifikator lain.'];
        }

        return [
            'boleh'            => true,
            'urutan'           => $urutanAktif,
            'role_verifikator' => $giliranAlur->role_verifikator,
            'total_urutan'     => $alur->count(),
            'record_giliran'   => $recordGiliran,
        ];
    }

    private function ambilAlurVerifikasi(Peminjaman $peminjaman)
    {
        $peminjaman->loadMissing([
            'pemohon.roles',
            'ruangan.jenisRuangan',
        ]);

        $jenisPemohon = optional($peminjaman->pemohon)
            ->roles
            ->pluck('nama')
            ->map(fn ($role) => strtolower(trim($role)))
            ->first();

        if (!$jenisPemohon) {
            return collect();
        }

        $jenisRuangSlug = strtolower(trim($peminjaman->ruangan->jenisRuangan->slug ?? ''));
        $jenisRuangNama = strtolower(trim($peminjaman->ruangan->jenisRuangan->nama ?? ''));

        $isLab = str_contains($jenisRuangSlug, 'lab') || str_contains($jenisRuangNama, 'lab');

        return AlurVerifikasi::whereRaw('LOWER(TRIM(jenis_pemohon)) = ?', [$jenisPemohon])
            ->when(!$isLab, function ($q) {
                $q->whereRaw('LOWER(TRIM(role_verifikator)) != ?', ['kalab']);
            })
            ->orderBy('urutan')
            ->get()
            ->values();
    }

    private function kirimNotifikasiKeRole(string $role, Peminjaman $peminjaman): void
    {
        $role = strtolower(trim($role));

        $users = User::whereHas('roles', function ($q) use ($role) {
            $q->whereRaw('LOWER(TRIM(nama)) = ?', [$role]);
        })->get();

        Log::info('[notifikasi] kirim ke role', [
            'role'          => $role,
            'jumlah_user'   => $users->count(),
            'peminjaman_id' => $peminjaman->id,
        ]);

        foreach ($users as $user) {
            $user->notify(new PengajuanPeminjamanNotification($peminjaman));
        }
    }

    public function approve(Request $request, Peminjaman $peminjaman)
    {
        Log::info('=== APPROVE START ===', [
            'peminjaman_id' => $peminjaman->id,
            'status'        => $peminjaman->status,
            'user'          => Auth::user()->nomor_induk,
            'user_role'     => Auth::user()->roles->pluck('nama')->first() ?? Auth::user()->role,
            'pemohon_attrs' => $peminjaman->pemohon?->getAttributes(),
        ]);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $cek = $this->cekGiliran($peminjaman);

        Log::info('[approve] cekGiliran result', $cek);

        if (!$cek['boleh']) {
            return back()->with('error', $cek['pesan']);
        }

        $isFinal     = false;
        $urutan      = $cek['urutan'];
        $totalUrutan = $cek['total_urutan'];

        try {
            DB::transaction(function () use ($peminjaman, $cek, &$isFinal, &$urutan, &$totalUrutan) {
                $user = Auth::user();

                $urutan      = $cek['urutan'];
                $totalUrutan = $cek['total_urutan'];
                $isFinal     = ($urutan === $totalUrutan);

                Verifikasi::updateOrCreate(
                    [
                        'id_peminjaman' => $peminjaman->id,
                        'urutan'        => $urutan,
                    ],
                    [
                        'id_verifikator'    => $user->nomor_induk,
                        'role_verifikator'  => strtolower(trim(
                            $user->roles->pluck('nama')->first() ?? $user->role
                        )),
                        'status_verifikasi' => 'disetujui',
                        'waktu_verifikasi'  => now(),
                        'catatan'           => null,
                    ]
                );

                if ($isFinal) {
                    $peminjaman->update([
                        'status' => 'disetujui',
                    ]);
                }

                Log::info('[approve] update verifikasi berhasil', [
                    'peminjaman_id' => $peminjaman->id,
                    'urutan'        => $urutan,
                    'total_urutan'  => $totalUrutan,
                    'is_final'      => $isFinal,
                ]);
            });

            $peminjaman->refresh()->load([
                'pemohon.roles',
                'ruangan.jenisRuangan',
            ]);

            if (!$peminjaman->pemohon) {
                Log::warning('[notifikasi] pemohon tidak ditemukan', [
                    'peminjaman_id' => $peminjaman->id,
                ]);

                Alert::success('Berhasil', 'Verifikasi berhasil, tetapi data pemohon tidak ditemukan.');
                return back();
            }

            if ($isFinal) {
                $peminjaman->pemohon->notify(
                    new VerifikasiPeminjamanNotification(
                        $peminjaman,
                        'disetujui'
                    )
                );

                Log::info('[notifikasi] pemohon disetujui', [
                    'peminjaman_id' => $peminjaman->id,
                    'pemohon_id'    => $peminjaman->pemohon->nomor_induk ?? null,
                ]);
            } else {
                $alur = $this->ambilAlurVerifikasi($peminjaman);

                $nextStep = $alur->get($urutan);

                if ($nextStep) {
                    $nextRole = strtolower(trim($nextStep->role_verifikator));

                    $this->kirimNotifikasiKeRole($nextRole, $peminjaman);

                    $peminjaman->pemohon->notify(
                        new VerifikasiPeminjamanNotification(
                            $peminjaman,
                            'diproses ke tahap berikutnya'
                        )
                    );

                    Log::info('[notifikasi] pemohon lanjut tahap', [
                        'peminjaman_id' => $peminjaman->id,
                        'pemohon_id'    => $peminjaman->pemohon->nomor_induk ?? null,
                        'next_urutan'   => $urutan + 1,
                        'next_role'     => $nextRole,
                    ]);
                } else {
                    Log::warning('[approve] nextStep alur tidak ditemukan padahal belum final', [
                        'peminjaman_id' => $peminjaman->id,
                        'urutan'        => $urutan,
                        'total_urutan'  => $totalUrutan,
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error('[approve] exception', [
                'message'       => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
                'peminjaman_id' => $peminjaman->id,
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $pesan = ($urutan === $totalUrutan)
            ? 'Pengajuan disetujui. Semua langkah verifikasi selesai.'
            : "Langkah {$urutan} dari {$totalUrutan} disetujui. Menunggu verifikasi berikutnya.";

        Alert::success('Berhasil', $pesan);

        return back();
    }

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

        Alert::success('Berhasil', "Pengajuan ditolak pada langkah {$cek['urutan']}.");

        return back();
    }
}
