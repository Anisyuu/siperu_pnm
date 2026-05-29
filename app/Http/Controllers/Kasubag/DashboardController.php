<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $userRoles = $user->roles
            ->pluck('nama')
            ->map(fn ($role) => strtolower(trim($role)))
            ->toArray();

        $jenisPemohonDiizinkan = DB::table('alur_verifikasi')
            ->whereIn(DB::raw('LOWER(role_verifikator)'), $userRoles)
            ->pluck('jenis_pemohon')
            ->unique()
            ->toArray();

        $anchor = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)
            : now();

        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = $weekStart->copy()->addDays(6);

        /*
        |--------------------------------------------------------------------------
        | STAT CARD KASUBAG
        |--------------------------------------------------------------------------
        */

        $baseKasubagQuery = Peminjaman::query()
            ->whereHas('pemohon.roles', function ($q) use ($jenisPemohonDiizinkan) {
                $q->whereIn('nama', $jenisPemohonDiizinkan);
            });

        $menunggu = (clone $baseKasubagQuery)
            ->where('status', 'pending')
            ->whereDoesntHave('verifikasi', function ($q) use ($user) {
                $q->where('id_verifikator', $user->nomor_induk);
            })
            ->count();

        $disetujui = Peminjaman::query()
            ->where('status', 'disetujui')
            ->whereHas('verifikasi', function ($q) use ($user) {
                $q->where('id_verifikator', $user->nomor_induk)
                  ->where('status_verifikasi', 'disetujui');
            })
            ->count();

        $ditolak = Peminjaman::query()
            ->where('status', 'ditolak')
            ->whereHas('verifikasi', function ($q) use ($user) {
                $q->where('id_verifikator', $user->nomor_induk)
                  ->where('status_verifikasi', 'ditolak');
            })
            ->count();

        $total = $menunggu + $disetujui + $ditolak;

        /*
        |--------------------------------------------------------------------------
        | KALENDER JADWAL DAN PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        $jadwal = Jadwal::with('ruangan')
            ->whereDate('tanggal_mulai', '<=', $weekEnd->toDateString())
            ->whereDate('tanggal_selesai', '>=', $weekStart->toDateString())
            ->orderBy('tanggal_mulai')
            ->orderBy('waktu_mulai')
            ->get();

        $peminjaman = Peminjaman::with('ruangan')
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

        return view('layouts.kasubag.dashboard', [
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
            $tanggalMulai = Carbon::parse($item->tanggal_mulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($item->tanggal_selesai)->startOfDay();

            $start = $tanggalMulai->greaterThan($weekStart)
                ? $tanggalMulai
                : $weekStart->copy();

            $end = $tanggalSelesai->lessThan($weekEnd)
                ? $tanggalSelesai
                : $weekEnd->copy();

            $events = collect();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $events->push([
                    'tanggal'       => $date->toDateString(),
                    'waktu_mulai'   => $item->waktu_mulai,
                    'waktu_selesai' => $item->waktu_selesai,
                    'title'         => $item->kegiatan,
                    'subtitle'      => $item->penanggung_jawab ?? $item->catatan,
                    'ruangan'       => $item->ruangan->nama_ruang ?? '-',
                    'type'          => 'jadwal',
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

            $events = collect();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $events->push([
                    'tanggal'       => $date->toDateString(),
                    'waktu_mulai'   => $item->waktu_mulai,
                    'waktu_selesai' => $item->waktu_selesai,
                    'title'         => 'Peminjaman Pada Ruang ' . ($item->ruangan->nama_ruang ?? '-'),
                    'subtitle'      => $item->kegiatan,
                    'ruangan'       => $item->ruangan->nama_ruang ?? '-',
                    'type'          => 'peminjaman',
                ]);
            }

            return $events;
        });
    }
}
