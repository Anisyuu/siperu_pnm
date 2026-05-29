<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function jadwalRuangan(Request $request)
    {
        // ===== 1. Tentukan minggu =====
        $anchor    = $request->filled('tanggal') ? Carbon::parse($request->tanggal) : now();
        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = $weekStart->copy()->addDays(6);

        // ===== 2. Ambil jadwal penggunaan ruangan =====
        $jadwal = Jadwal::with('ruangan')
            ->whereDate('tanggal_mulai', '<=', $weekEnd->toDateString())
            ->whereDate('tanggal_selesai', '>=', $weekStart->toDateString())
            ->when($request->ruangan_id, fn ($q) =>
                $q->where('ruangan_id', $request->ruangan_id)
            )
            ->when($request->keyword, function ($q) use ($request) {
                $kw = $request->keyword;

                $q->where(function ($sub) use ($kw) {
                    $sub->where('kegiatan', 'like', "%{$kw}%")
                        ->orWhere('penanggung_jawab', 'like', "%{$kw}%")
                        ->orWhere('catatan', 'like', "%{$kw}%")
                        ->orWhereHas('ruangan', function ($ruangan) use ($kw) {
                            $ruangan->where('nama_ruang', 'like', "%{$kw}%");
                        });
                });
            })
            ->orderBy('tanggal_mulai')
            ->orderBy('waktu_mulai')
            ->get();

        // ===== 3. Ambil peminjaman disetujui =====
        $peminjaman = Peminjaman::with(['ruangan', 'pemohon'])
            ->whereIn('status', ['disetujui'])
            ->whereDate('tanggal_mulai', '<=', $weekEnd->toDateString())
            ->whereDate('tanggal_selesai', '>=', $weekStart->toDateString())
            ->when($request->ruangan_id, fn ($q) =>
                $q->where('ruangan_id', $request->ruangan_id)
            )
            ->when($request->keyword, function ($q) use ($request) {
                $kw = $request->keyword;

                $q->where(function ($sub) use ($kw) {
                    $sub->where('kegiatan', 'like', "%{$kw}%")
                        ->orWhere('catatan', 'like', "%{$kw}%")
                        ->orWhereHas('ruangan', function ($ruangan) use ($kw) {
                            $ruangan->where('nama_ruang', 'like', "%{$kw}%");
                        })
                        ->orWhereHas('pemohon', function ($pemohon) use ($kw) {
                            $pemohon->where('nama_lengkap', 'like', "%{$kw}%")
                                ->orWhere('nomor_induk', 'like', "%{$kw}%");
                        });
                });
            })
            ->orderBy('tanggal_mulai')
            ->orderBy('waktu_mulai')
            ->get();

        // ===== 4. Mapping ke format event =====
        $events = collect()
            ->merge($this->mapJadwal($jadwal, $weekStart, $weekEnd))
            ->merge($this->mapPeminjaman($peminjaman, $weekStart, $weekEnd))
            ->sortBy([
                ['tanggal', 'asc'],
                ['waktu_mulai', 'asc'],
            ])
            ->values();

        // ===== 5. Grouping berdasarkan tanggal + overlap seperti dashboard =====
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

        // ===== 6. Generate hari =====
        $days = collect(range(0, 6))
            ->map(fn ($i) => $weekStart->copy()->addDays($i));

        return view('layouts.sarpras.jadwal.jadwal_ruangan', [
            'ruangan'       => Ruangan::orderBy('nama_ruang')->get(),
            'events'        => $events,
            'eventsByDate'  => $eventsByDate,
            'days'          => $days,
            'weekStart'     => $weekStart,
            'weekEnd'       => $weekEnd,
            'monthLabel'    => $weekStart->locale('id')->translatedFormat('F Y'),
        ]);
    }

    private function mapJadwal($data, Carbon $weekStart, Carbon $weekEnd)
    {
        return $data->flatMap(function ($item) use ($weekStart, $weekEnd) {
            $tanggalMulai = Carbon::parse($item->tanggal_mulai)->startOfDay();
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
            $tanggalMulai = Carbon::parse($item->tanggal_mulai)->startOfDay();
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
