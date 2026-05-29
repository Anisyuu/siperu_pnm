<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait ExportRiwayatCsv
{
    protected function applyRiwayatFilters($query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kegiatan', 'like', '%' . $search . '%')
                    ->orWhere('no_peminjaman', 'like', '%' . $search . '%')
                    ->orWhereHas('pemohon', function ($pemohon) use ($search) {
                        $pemohon->where('nama_lengkap', 'like', '%' . $search . '%')
                            ->orWhere('nomor_induk', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('ruangan', function ($ruangan) use ($search) {
                        $ruangan->where('nama_ruang', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', '=', $request->status);
        }
    }

    protected function downloadRiwayatCsv($peminjaman, string $fileName, ?string $userId = null)
    {
        return response()->streamDownload(function () use ($peminjaman, $userId) {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 agar karakter Indonesia aman di Excel
            fwrite($handle, "\xEF\xBB\xBF");

            // Agar Excel langsung membaca pemisah kolom dengan rapi
            fwrite($handle, "sep=;\r\n");

            fputcsv($handle, [
                'No',
                'Nomor Peminjaman',
                'Tanggal Pengajuan',
                'Nama Pemohon',
                'Nomor Induk',
                'Email',
                'Nama Ruangan',
                'Gedung',
                'Lantai',
                'Kampus',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Waktu Mulai',
                'Waktu Selesai',
                'Nama Kegiatan',
                'Status Akhir',
                'Langkah Verifikasi',
                'Peran Verifikator',
                'Status Verifikasi',
                'Waktu Verifikasi',
                'Catatan',
            ], ';');

            foreach ($peminjaman as $index => $p) {
                $langkahSaya = null;

                if ($userId) {
                    $langkahSaya = $p->verifikasi
                        ->where('id_verifikator', $userId)
                        ->sortBy('urutan')
                        ->first();
                }

                $totalLangkah = $p->verifikasi ? $p->verifikasi->count() : 0;

                fputcsv($handle, [
                    $index + 1,
                    $p->no_peminjaman ?? '-',

                    $p->created_at
                        ? Carbon::parse($p->created_at)->format('d-m-Y H:i')
                        : '-',

                    $p->pemohon->nama_lengkap ?? '-',
                    $p->pemohon->nomor_induk ?? '-',
                    $p->pemohon->email ?? '-',

                    $p->ruangan->nama_ruang ?? '-',
                    $p->ruangan->gedung->nama ?? '-',
                    $p->ruangan->lantai ?? '-',
                    $p->ruangan->gedung->kampus->nama_kampus ?? '-',

                    $p->tanggal_mulai
                        ? Carbon::parse($p->tanggal_mulai)->format('d-m-Y')
                        : '-',

                    $p->tanggal_selesai
                        ? Carbon::parse($p->tanggal_selesai)->format('d-m-Y')
                        : '-',

                    $p->waktu_mulai
                        ? Carbon::parse($p->waktu_mulai)->format('H:i')
                        : '-',

                    $p->waktu_selesai
                        ? Carbon::parse($p->waktu_selesai)->format('H:i')
                        : '-',

                    $p->kegiatan ?? '-',
                    $this->formatStatusExport($p->status),

                    $langkahSaya
                        ? 'Urutan ' . $langkahSaya->urutan . '/' . $totalLangkah
                        : '-',

                    $langkahSaya->role_verifikator ?? '-',

                    $langkahSaya
                        ? $this->formatStatusVerifikasiExport($langkahSaya->status_verifikasi)
                        : '-',

                    $langkahSaya && $langkahSaya->waktu_verifikasi
                        ? Carbon::parse($langkahSaya->waktu_verifikasi)->format('d-m-Y H:i')
                        : '-',

                    $langkahSaya->catatan ?? ($p->catatan ?? '-'),
                ], ';');
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function formatStatusExport(?string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => $status ?? '-',
        };
    }

    protected function formatStatusVerifikasiExport(?string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => $status ?? '-',
        };
    }
}
