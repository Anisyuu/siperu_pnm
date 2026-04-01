<x-master>
@php
    // Pengaturan “calendar grid”
    $startHour = 0;   // mulai jam 00:00
    $endHour   = 23;  // sampai jam 23:00
    $slotHeight = 80; // tinggi 1 jam = 80px
    $totalHours = ($endHour - $startHour) + 1; // hasil = 24 jam

    $prevWeekTanggal = $weekStart->copy()->subDays(7)->toDateString();
    $nextWeekTanggal = $weekStart->copy()->addDays(7)->toDateString();

    // palette sederhana biar event beda warna (berdasarkan ruangan_id)
    $palette = [
        ['bg' => 'bg-primary/10', 'border' => 'border-primary', 'title' => 'text-primary', 'time' => 'text-primary/80'],
        ['bg' => 'bg-purple-100', 'border' => 'border-purple-500', 'title' => 'text-purple-700', 'time' => 'text-purple-600'],
        ['bg' => 'bg-orange-100', 'border' => 'border-orange-500', 'title' => 'text-orange-700', 'time' => 'text-orange-600'],
        ['bg' => 'bg-emerald-100', 'border' => 'border-emerald-500', 'title' => 'text-emerald-700', 'time' => 'text-emerald-600'],
    ];
@endphp

<div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                    Jadwal Ruangan
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    Lihat dan filter jadwal penggunaan ruangan
                </p>
            </div>

            <div class="flex items-center gap-2 text-sm text-slate-500 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm">
                <i class="fa-regular fa-calendar-days"></i>
                <span>{{ now()->locale('id')->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <!-- FILTER SECTION -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row gap-4 md:items-end">

                <!-- Ruangan -->
                <div class="flex flex-col flex-1">
                    <label class="text-xs font-semibold text-slate-500 mb-1">Ruangan</label>
                    <select name="ruangan_id"
                            class="px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">
                        <option value="">Semua Ruangan</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" @selected(request('ruangan_id') == $r->id)>
                                {{ $r->nama_ruang ?? $r->nama ?? ('Ruangan #' . $r->id) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal (anchor minggu) -->
                <div class="flex flex-col flex-1">
                    <label class="text-xs font-semibold text-slate-500 mb-1">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           value="{{ request('tanggal', $weekStart->toDateString()) }}"
                           class="px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">
                </div>

                <!-- Keyword -->
                <div class="flex flex-col flex-1">
                    <label class="text-xs font-semibold text-slate-500 mb-1">Cari</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                           placeholder="Mata kuliah / Dosen / Catatan"
                           class="px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">
                </div>

                <!-- Buttons -->
                <div class="flex shrink-0 gap-2">
                    <button type="submit"
                            class="h-11 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                        Terapkan
                    </button>

                    <a href="{{ url()->current() }}"
                       class="h-11 px-4 inline-flex items-center justify-center text-sm font-semibold rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-slate-700">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-4">

            <!-- TOP RIGHT CONTROLS -->
            <div class="flex justify-end">
                <div class="flex items-center bg-white rounded-lg border border-slate-200 px-3 py-1.5 shadow-sm">

                    {{-- prev week (jaga filter lain) --}}
                    <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $prevWeekTanggal])) }}"
                       class="p-1.5 hover:bg-slate-100 rounded-md transition-colors text-slate-500">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>

                    <span class="px-4 text-sm font-bold text-slate-800">
                        {{ $monthLabel }}
                    </span>

                    {{-- next week --}}
                    <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $nextWeekTanggal])) }}"
                       class="p-1.5 hover:bg-slate-100 rounded-md transition-colors text-slate-500">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>

                    <div class="w-px h-4 bg-slate-200 mx-2"></div>

                    <button type="button" class="px-3 py-1 text-xs font-bold bg-primary text-white rounded-md shadow-sm">
                        Minggu
                    </button>

                    <button type="button" disabled
                            class="px-3 py-1 text-xs font-medium text-slate-400 rounded-md opacity-50 cursor-not-allowed">
                        Bulan
                    </button>
                </div>
            </div>

            <!-- CALENDAR -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[500px]">

                <!-- DAY HEADER -->
                <div class="flex border-b border-slate-200 bg-slate-50 z-20">
                    <div class="w-16 shrink-0 border-r border-slate-200 flex items-center justify-center p-2">
                        <span class="text-xs font-bold text-slate-500">GMT+7</span>
                    </div>

                    <div class="flex-1 overflow-hidden">
                        <div class="grid grid-cols-7 w-full min-w-[700px]">
                            @foreach($days as $day)
                                @php
                                    $isToday = $day->isSameDay(now());
                                    $isWeekend = in_array($day->dayOfWeekIso, [6,7]); // Sab=6 Min=7
                                    $abbr = $day->locale('id')->translatedFormat('D'); // Sen, Sel, ...
                                @endphp

                                <div class="p-3 border-r border-slate-200 text-center
                                    {{ $isToday ? 'bg-primary/5' : ($isWeekend ? 'bg-slate-50/70' : 'group cursor-pointer hover:bg-slate-50 transition-colors') }}">
                                    <p class="text-xs {{ $isWeekend ? 'text-red-400 font-medium' : ($isToday ? 'text-primary font-bold' : 'text-slate-500 font-medium group-hover:text-primary') }} mb-1">
                                        {{ $abbr }}
                                    </p>

                                    @if($isToday)
                                        <div class="size-8 mx-auto flex items-center justify-center bg-primary text-white rounded-full font-bold text-sm shadow-md">
                                            {{ $day->format('d') }}
                                        </div>
                                    @else
                                        <div class="size-8 mx-auto flex items-center justify-center {{ $isWeekend ? 'text-slate-400' : 'text-slate-800' }} font-bold text-sm">
                                            {{ $day->format('d') }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="flex-1 overflow-y-auto relative custom-scrollbar">
                    <div class="flex min-h-[600px]">

                        <!-- TIME GUTTER 30 MENIT -->
                        <div class="w-16 shrink-0 flex flex-col border-r border-slate-200 bg-white sticky left-0 z-10">
                            @for($time = $startHour * 60; $time <= $endHour * 60; $time += 30)
                                @php
                                    $hour = floor($time / 60);
                                    $minute = $time % 60;
                                @endphp

                                <div class="h-10 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">
                                        {{ sprintf('%02d:%02d', $hour, $minute) }}
                                    </span>
                                </div>
                            @endfor
                        </div>

                        <!-- GRID -->
                        <div class="flex-1 min-w-[700px] grid grid-cols-7 relative bg-white"
                             style="min-height: {{ $totalHours * $slotHeight }}px;">

                            <!-- dashed lines overlay -->
                            <div class="absolute inset-0 flex flex-col pointer-events-none">
                                @for($i=0; $i<$totalHours; $i++)
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                @endfor
                            </div>

                            @foreach($days as $day)
                                @php
                                    $dateKey = $day->toDateString();
                                    $dayEvents = $eventsByDate->get($dateKey, collect());
                                    $isWeekend = in_array($day->dayOfWeekIso, [6,7]);
                                @endphp

                                <div class="border-r border-slate-200 relative h-full {{ $isWeekend ? 'bg-slate-50/50' : '' }}">
                                    @foreach($dayEvents as $ev)
                                        @php
                                            $start = \Illuminate\Support\Carbon::parse($ev->waktu_mulai);
                                            $end   = \Illuminate\Support\Carbon::parse($ev->waktu_selesai);

                                            // menit dari startHour
                                            $startMinutes = ($start->hour * 60 + $start->minute) - ($startHour * 60);
                                            $endMinutes   = ($end->hour * 60 + $end->minute) - ($startHour * 60);

                                            // clamp biar gak keluar container
                                            $startMinutes = max(0, $startMinutes);
                                            $endMinutes   = min($totalHours * 60, $endMinutes);

                                            $duration  = max(15, $endMinutes - $startMinutes); // minimal 15 menit
                                            $topPx     = ($startMinutes / 60) * $slotHeight;
                                            $heightPx  = ($duration / 60) * $slotHeight;

                                            $idx = ($ev->ruangan_id ?? 0) % count($palette);
                                            $c = $palette[$idx];

                                            $title = $ev->mata_kuliah;
                                            $timeText = $start->format('H:i') . ' - ' . $end->format('H:i');
                                        @endphp

                                        <div class="absolute left-1 right-1 rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm {{ $c['bg'] }} border-l-4 {{ $c['border'] }}"
                                             style="top: {{ $topPx }}px; height: {{ $heightPx }}px;">
                                            <p class="text-[11px] font-bold truncate {{ $c['title'] }}">
                                                {{ $title }}
                                            </p>
                                            <p class="text-[10px] truncate {{ $c['time'] }}">
                                                {{ $timeText }}
                                            </p>
                                            <p class="mt-1 text-[10px] text-slate-500 truncate">
                                                {{ $ev->dosen_pengampu }}
                                                @if($ev->ruangan)
                                                    • {{ $ev->ruangan->nama_ruang ?? $ev->ruangan->nama ?? ('Ruangan #' . $ev->ruangan_id) }}
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>

            @if($jadwal->count() === 0)
                <div class="text-sm text-slate-500 text-center py-6">
                    Tidak ada jadwal pada minggu ini dengan filter yang dipilih.
                </div>
            @endif

        </div>
    </div>
</div>
</x-master>
