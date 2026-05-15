<?php

namespace App\Http\Controllers\Kalab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function jadwalRuangan(Request $request)
    {
        // ===== 1. Tentukan minggu =====
        $anchor    = $request->filled('tanggal') ? Carbon::parse($request->tanggal) : now();
        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = $weekStart->copy()->addDays(6);

        // ===== 2. Ambil jadwal =====
        $jadwal = Jadwal::with('ruangan')
            ->whereBetween('tanggal', [$weekStart, $weekEnd])
            ->when($request->ruangan_id, fn ($q) =>
                $q->where('ruangan_id', $request->ruangan_id)
            )
            ->when($request->keyword, function ($q) use ($request) {
                $kw = $request->keyword;
                $q->where(fn ($sub) =>
                    $sub->where('mata_kuliah', 'like', "%$kw%")
                        ->orWhere('dosen_pengampu', 'like', "%$kw%")
                        ->orWhere('catatan', 'like', "%$kw%")
                );
            })
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        // ===== 3. Ambil peminjaman =====
        $peminjaman = Peminjaman::with('ruangan')
            ->whereIn('status', ['disetujui'])
            ->where(function ($q) use ($weekStart, $weekEnd) {
                $q->whereBetween('tanggal_mulai', [$weekStart, $weekEnd])
                  ->orWhereBetween('tanggal_selesai', [$weekStart, $weekEnd]);
            })
            ->get();

        // ===== 4. Mapping ke format event =====
        $events = collect()
            ->merge($this->mapJadwal($jadwal))
            ->merge($this->mapPeminjaman($peminjaman))
            ->sortBy(['tanggal', 'waktu_mulai'])
            ->values();

        // ===== 5. Grouping =====
        $eventsByDate = $events->groupBy(fn ($e) =>
            Carbon::parse($e['tanggal'])->toDateString()
        );

        // ===== 6. Generate hari =====
        $days = collect(range(0, 6))
            ->map(fn ($i) => $weekStart->copy()->addDays($i));

        return view('layouts.kalab.jadwal.jadwal_ruangan', [
            'ruangan'       => Ruangan::orderBy('nama_ruang')->get(),
            'events'        => $events,
            'eventsByDate'  => $eventsByDate,
            'days'          => $days,
            'weekStart'     => $weekStart,
            'weekEnd'       => $weekEnd,
            'monthLabel'    => $weekStart->translatedFormat('F Y'),
        ]);
    }

    // ===== Helper: mapping jadwal =====
    private function mapJadwal($data)
    {
        return $data->map(fn ($item) => [
            'tanggal'        => $item->tanggal,
            'waktu_mulai'    => $item->waktu_mulai,
            'waktu_selesai'  => $item->waktu_selesai,
            'title'          => $item->mata_kuliah,
            'subtitle'       => $item->dosen_pengampu,
            'ruangan'        => $item->ruangan->nama_ruang ?? '-',
            'type'           => 'jadwal',
        ]);
    }

    // ===== Helper: mapping peminjaman =====
    private function mapPeminjaman($data)
    {
        {
        return $data->map(fn ($item) => [
            'tanggal'        => $item->tanggal_mulai,
            'waktu_mulai'    => $item->waktu_mulai,
            'waktu_selesai'  => $item->waktu_selesai,
            'title'          => "Peminjaman Pada Ruang " . $item->ruangan->nama_ruang,
            'subtitle'       => $item->kegiatan,
            'ruangan'        => $item->ruangan->nama_ruang ?? '-',
            'type'           => 'peminjaman',
        ]);
    }

    }
}
