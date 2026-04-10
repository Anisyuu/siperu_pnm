<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Carbon;
use App\Models\Ruangan;

class JadwalController extends Controller
{
    public function jadwalRuangan(Request $request)
    {
        // tanggal acuan (kalau kosong => hari ini)
        $anchor = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)
            : now();

        // minggu dimulai Senin
        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $weekEnd   = $weekStart->copy()->addDays(6)->endOfDay();

        // query jadwal (week range)
        $q = Jadwal::query()->with('ruangan')
            ->whereBetween('tanggal', [$weekStart->toDateString(), $weekEnd->toDateString()]);

        // filter ruangan
        if ($request->filled('ruangan_id')) {
            $q->where('ruangan_id', $request->ruangan_id);
        }

        // keyword (mata kuliah / dosen / catatan)
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $q->where(function ($sub) use ($kw) {
                $sub->where('mata_kuliah', 'like', "%{$kw}%")
                    ->orWhere('dosen_pengampu', 'like', "%{$kw}%")
                    ->orWhere('catatan', 'like', "%{$kw}%");
            });
        }

        $jadwal = $q->orderBy('tanggal')->orderBy('waktu_mulai')->get();

        // list ruangan untuk dropdown (sesuaikan field nama kalau beda)
        $ruangan = Ruangan::orderBy('nama_ruang')->get();

        // array 7 hari (Sen–Min)
        $days = collect(range(0, 6))->map(fn ($i) => $weekStart->copy()->addDays($i));

        // group event by tanggal (Y-m-d)
        $eventsByDate = $jadwal->groupBy(fn ($row) => Carbon::parse($row->tanggal)->toDateString());

        // label bulan (pakai start week)
        $monthLabel = $weekStart->locale('id')->translatedFormat('F Y');

        return view('layouts.dosen.jadwal.jadwal_ruangan', compact(
            'ruangan',
            'jadwal',
            'days',
            'eventsByDate',
            'weekStart',
            'weekEnd',
            'monthLabel'
        ));
    }
}
