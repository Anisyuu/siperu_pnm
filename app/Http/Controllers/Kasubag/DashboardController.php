<?php

namespace App\Http\Controllers\Kasubag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // minggu sekarang
        $anchor = now();

        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $weekEnd   = $weekStart->copy()->addDays(6)->endOfDay();

        $jadwal = Jadwal::with('ruangan')
            ->whereBetween('tanggal', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        $days = collect(range(0, 6))
            ->map(fn ($i) => $weekStart->copy()->addDays($i));

        $eventsByDate = $jadwal->groupBy(
            fn ($row) => Carbon::parse($row->tanggal)->toDateString()
        );

        $startHour = 0;
        $endHour = 23;
        $slotHeight = 80;
        $totalHours = ($endHour - $startHour) + 1;

        $palette = [
            ['bg'=>'bg-primary/10','border'=>'border-primary','title'=>'text-primary','time'=>'text-primary/80'],
            ['bg'=>'bg-purple-100','border'=>'border-purple-500','title'=>'text-purple-700','time'=>'text-purple-600'],
            ['bg'=>'bg-orange-100','border'=>'border-orange-500','title'=>'text-orange-700','time'=>'text-orange-600'],
            ['bg'=>'bg-emerald-100','border'=>'border-emerald-500','title'=>'text-emerald-700','time'=>'text-emerald-600'],
        ];

        // 🔥 TAMBAHAN PENTING
        $monthLabel = $weekStart->translatedFormat('F Y');

        return view('layouts.kasubag.dashboard', compact(
            'days',
            'eventsByDate',
            'startHour',
            'endHour',
            'slotHeight',
            'totalHours',
            'palette',

            // WAJIB TAMBAH INI
            'weekStart',
            'weekEnd',
            'jadwal',
            'monthLabel'
        ));
    }
}
