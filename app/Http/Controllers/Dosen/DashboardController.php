<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $userId = Auth::user()->nomor_induk;

        $anchor = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)
            : now();

        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = $weekStart->copy()->addDays(6);

        /*
        |--------------------------------------------------------------------------
        | STAT CARD PEMINJAM
        |--------------------------------------------------------------------------
        | Tidak diubah.
        | Hanya menghitung peminjaman milik user yang sedang login.
        |--------------------------------------------------------------------------
        */

        $basePeminjamanUser = Peminjaman::query()
            ->where('pemohon_id', $userId);

        $total     = (clone $basePeminjamanUser)->count();
        $menunggu  = (clone $basePeminjamanUser)->where('status', 'pending')->count();
        $disetujui = (clone $basePeminjamanUser)->where('status', 'disetujui')->count();
        $ditolak   = (clone $basePeminjamanUser)->where('status', 'ditolak')->count();

        /*
        |--------------------------------------------------------------------------
        | KALENDER JADWAL DAN PEMINJAMAN
        |--------------------------------------------------------------------------
        | Yang dibenahi hanya kalender.
        | Kalender menampilkan semua jadwal dan semua peminjaman yang sudah disetujui.
        |--------------------------------------------------------------------------
        */

        $jadwal = Jadwal::with('ruangan')
            ->whereDate('tanggal_mulai', '<=', $weekEnd->toDateString())
            ->whereDate('tanggal_selesai', '>=', $weekStart->toDateString())
            ->orderBy('tanggal_mulai')
            ->orderBy('waktu_mulai')
            ->get();

        $peminjaman = Peminjaman::with(['ruangan', 'pemohon'])
            ->where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $weekEnd->toDateString())
            ->whereDate('tanggal_selesai', '>=', $weekStart->toDateString())
            ->orderBy('tanggal_mulai')
            ->orderBy('waktu_mulai')
            ->get();

        $events = collect()
            ->merge($this->mapJadwal($jadwal, $weekStart, $weekEnd))
            ->merge($this->mapPeminjaman($peminjaman, $weekStart, $weekEnd))
            ->sortBy([
                ['tanggal', 'asc'],
                ['waktu_mulai', 'asc'],
            ])
            ->values();

        $eventsByDate = $events
            ->groupBy(fn ($event) => Carbon::parse($event['tanggal'])->toDateString())
            ->map(function ($dayEvents) {
                $dayEvents = $dayEvents
                    ->sortBy([
                        ['waktu_mulai', 'asc'],
                        ['waktu_selesai', 'asc'],
                    ])
                    ->values();

                $columns = [];
                $result = collect();

                foreach ($dayEvents as $event) {
                    $eventStart = Carbon::parse($event['waktu_mulai']);
                    $eventEnd   = Carbon::parse($event['waktu_selesai']);

                    $placedColumn = null;

                    foreach ($columns as $columnIndex => $lastEventEnd) {
                        if ($eventStart->gte($lastEventEnd)) {
                            $placedColumn = $columnIndex;
                            break;
                        }
                    }

                    if ($placedColumn === null) {
                        $placedColumn = count($columns);
                    }

                    $columns[$placedColumn] = $eventEnd;

                    $event['overlap_index'] = $placedColumn;

                    $result->push($event);
                }

                $overlapTotal = max(1, count($columns));

                return $result->map(function ($event) use ($overlapTotal) {
                    $event['overlap_total'] = $overlapTotal;
                    return $event;
                });
            });

        $days = collect(range(0, 6))
            ->map(fn ($i) => $weekStart->copy()->addDays($i));

        return view('layouts.dosen.dashboard', [
            'events'       => $events,
            'eventsByDate' => $eventsByDate,
            'days'         => $days,
            'weekStart'    => $weekStart,
            'weekEnd'      => $weekEnd,
            'monthLabel'   => $weekStart->locale('id')->translatedFormat('F Y'),

            'total'        => $total,
            'menunggu'     => $menunggu,
            'disetujui'    => $disetujui,
            'ditolak'      => $ditolak,
        ]);
    }

    private function mapJadwal($data, Carbon $weekStart, Carbon $weekEnd)
    {
        return $data->flatMap(function ($item) use ($weekStart, $weekEnd) {
            $tanggalMulai   = Carbon::parse($item->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($item->tanggal_selesai)->startOfDay();

            $start = $tanggalMulai->greaterThan($weekStart)
                ? $tanggalMulai
                : $weekStart->copy();

            $end = $tanggalSelesai->lessThan($weekEnd)
                ? $tanggalSelesai
                : $weekEnd->copy();

            $lokasi = $this->lokasiRuangan($item->ruangan);

            $events = collect();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $events->push([
                    'tanggal'           => $date->toDateString(),
                    'waktu_mulai'       => $item->waktu_mulai,
                    'waktu_selesai'     => $item->waktu_selesai,

                    'title'             => $item->kegiatan,
                    'penanggung_jawab'  => $item->penanggung_jawab ?? '-',
                    'catatan'           => $item->catatan ?? '-',
                    'type'              => 'jadwal',

                    'kampus'            => $lokasi['kampus'],
                    'gedung'            => $lokasi['gedung'],
                    'lantai'            => $lokasi['lantai'],
                    'ruangan'           => $lokasi['ruangan'],
                ]);
            }

            return $events;
        });
    }

    private function mapPeminjaman($data, Carbon $weekStart, Carbon $weekEnd)
    {
        return $data->flatMap(function ($item) use ($weekStart, $weekEnd) {
            $tanggalMulai   = Carbon::parse($item->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($item->tanggal_selesai)->startOfDay();

            $start = $tanggalMulai->greaterThan($weekStart)
                ? $tanggalMulai
                : $weekStart->copy();

            $end = $tanggalSelesai->lessThan($weekEnd)
                ? $tanggalSelesai
                : $weekEnd->copy();

            $lokasi = $this->lokasiRuangan($item->ruangan);

            $penanggungJawab = data_get($item, 'pemohon.nama_lengkap')
                ?? data_get($item, 'pemohon.nomor_induk')
                ?? '-';

            $events = collect();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $events->push([
                    'tanggal'           => $date->toDateString(),
                    'waktu_mulai'       => $item->waktu_mulai,
                    'waktu_selesai'     => $item->waktu_selesai,

                    'title'             => $item->kegiatan ?? 'Peminjaman Ruangan',
                    'penanggung_jawab'  => $penanggungJawab,
                    'catatan'           => $item->catatan ?? '-',
                    'type'              => 'peminjaman',

                    'kampus'            => $lokasi['kampus'],
                    'gedung'            => $lokasi['gedung'],
                    'lantai'            => $lokasi['lantai'],
                    'ruangan'           => $lokasi['ruangan'],
                ]);
            }

            return $events;
        });
    }

    private function lokasiRuangan($ruangan): array
    {
        $kampus = data_get($ruangan, 'kampus.nama_kampus')
            ?? data_get($ruangan, 'kampus.nama')
            ?? data_get($ruangan, 'gedung.kampus.nama_kampus')
            ?? data_get($ruangan, 'gedung.kampus.nama')
            ?? data_get($ruangan, 'nama_kampus');

        $gedung = data_get($ruangan, 'gedung.nama_gedung')
            ?? data_get($ruangan, 'gedung.nama')
            ?? data_get($ruangan, 'nama_gedung');

        $lantai = data_get($ruangan, 'lantai.nama_lantai')
            ?? data_get($ruangan, 'lantai.nama')
            ?? data_get($ruangan, 'nama_lantai')
            ?? data_get($ruangan, 'lantai');

        $namaRuangan = data_get($ruangan, 'nama_ruang')
            ?? data_get($ruangan, 'nama')
            ?? data_get($ruangan, 'kode_ruang');

        return [
            'kampus'  => $this->nilaiLokasi($kampus),
            'gedung'  => $this->nilaiLokasi($gedung),
            'lantai'  => $this->nilaiLokasi($lantai),
            'ruangan' => $this->nilaiLokasi($namaRuangan),
        ];
    }

    private function nilaiLokasi($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_object($value) || is_array($value)) {
            return '-';
        }

        return (string) $value;
    }
}
