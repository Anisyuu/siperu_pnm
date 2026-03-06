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
        ['bg' => 'bg-purple-100 dark:bg-purple-900/40', 'border' => 'border-purple-500', 'title' => 'text-purple-700 dark:text-purple-300', 'time' => 'text-purple-600 dark:text-purple-400'],
        ['bg' => 'bg-orange-100 dark:bg-orange-900/40', 'border' => 'border-orange-500', 'title' => 'text-orange-700 dark:text-orange-300', 'time' => 'text-orange-600 dark:text-orange-400'],
        ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'border' => 'border-emerald-500', 'title' => 'text-emerald-700 dark:text-emerald-300', 'time' => 'text-emerald-600 dark:text-emerald-400'],
    ];
@endphp

<div class="max-w-7xl flex flex-col gap-8 p-10 rounded-2xl bg-white/80 shadow me-3">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Jadwal Ruangan
            </h2>
            <p class="text-text-secondary text-sm mt-1">
                Lihat dan filter jadwal penggunaan ruangan
            </p>
        </div>

        <div class="flex items-center gap-2 text-sm text-text-secondary bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-700">
            <i class="fa-regular fa-calendar-days"></i>
            <span>{{ now()->locale('id')->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-subtle dark:border-gray-700 shadow-sm p-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row gap-4 md:items-end">

            <!-- Ruangan -->
            <div class="flex flex-col flex-1">
                <label class="text-xs font-semibold text-text-secondary mb-1">Ruangan</label>
                <select name="ruangan_id"
                        class="px-3 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none">
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
                <label class="text-xs font-semibold text-text-secondary mb-1">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal', $weekStart->toDateString()) }}"
                       class="px-3 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none">
            </div>

            <!-- Keyword -->
            <div class="flex flex-col flex-1">
                <label class="text-xs font-semibold text-text-secondary mb-1">Cari</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                       placeholder="Mata kuliah / Dosen / Catatan"
                       class="px-3 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex shrink-0 gap-2">
                <button type="submit"
                        class="h-10 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                    Terapkan
                </button>

                <a href="{{ url()->current() }}"
                   class="h-10 px-4 inline-flex items-center justify-center text-sm font-semibold rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-4">

        <!-- TOP RIGHT CONTROLS -->
        <div class="flex justify-end">
            <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border border-border-subtle dark:border-gray-700 px-3 py-1.5 shadow-sm">

                {{-- prev week (jaga filter lain) --}}
                <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $prevWeekTanggal])) }}"
                   class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-text-secondary">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>

                <span class="px-4 text-sm font-bold text-text-main dark:text-white">
                    {{ $monthLabel }}
                </span>

                {{-- next week --}}
                <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $nextWeekTanggal])) }}"
                   class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-text-secondary">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <div class="w-px h-4 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                <button type="button" class="px-3 py-1 text-xs font-bold bg-primary text-white rounded-md shadow-sm">
                    Minggu
                </button>

                <button type="button" disabled
                        class="px-3 py-1 text-xs font-medium text-text-secondary rounded-md opacity-50 cursor-not-allowed">
                    Bulan
                </button>
            </div>
        </div>

        <!-- CALENDAR -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden flex flex-col h-[500px]">

            <!-- DAY HEADER -->
            <div class="flex border-b border-border-subtle dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 z-20">
                <div class="w-16 shrink-0 border-r border-border-subtle dark:border-gray-700 flex items-center justify-center p-2">
                    <span class="text-xs font-bold text-text-secondary">GMT+7</span>
                </div>

                <div class="flex-1 overflow-hidden">
                    <div class="grid grid-cols-7 w-full min-w-[700px]">
                        @foreach($days as $day)
                            @php
                                $isToday = $day->isSameDay(now());
                                $isWeekend = in_array($day->dayOfWeekIso, [6,7]); // Sab=6 Min=7
                                $abbr = $day->locale('id')->translatedFormat('D'); // Sen, Sel, ...
                            @endphp

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center
                                {{ $isToday ? 'bg-primary/5 dark:bg-primary/10' : ($isWeekend ? 'bg-gray-50/30 dark:bg-gray-800/50' : 'group cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors') }}">
                                <p class="text-xs {{ $isWeekend ? 'text-red-400 font-medium' : ($isToday ? 'text-primary font-bold' : 'text-text-secondary font-medium group-hover:text-primary') }} mb-1">
                                    {{ $abbr }}
                                </p>

                                @if($isToday)
                                    <div class="size-8 mx-auto flex items-center justify-center bg-primary text-white rounded-full font-bold text-sm shadow-md">
                                        {{ $day->format('d') }}
                                    </div>
                                @else
                                    <div class="size-8 mx-auto flex items-center justify-center {{ $isWeekend ? 'text-text-secondary' : 'text-text-main dark:text-white' }} font-bold text-sm">
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
                    <div class="w-16 shrink-0 flex flex-col border-r border-border-subtle dark:border-gray-700 bg-white dark:bg-gray-800 sticky left-0 z-10">
                        @for($time = $startHour * 60; $time <= $endHour * 60; $time += 30)
                            @php
                                $hour = floor($time / 60);
                                $minute = $time % 60;
                            @endphp

                            <div class="h-10 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">
                                    {{ sprintf('%02d:%02d', $hour, $minute) }}
                                </span>
                            </div>
                        @endfor
                    </div>

                    <!-- GRID -->
                    <div class="flex-1 min-w-[700px] grid grid-cols-7 relative bg-white dark:bg-gray-800"
                         style="min-height: {{ $totalHours * $slotHeight }}px;">

                        <!-- dashed lines overlay -->
                        <div class="absolute inset-0 flex flex-col pointer-events-none">
                            @for($i=0; $i<$totalHours; $i++)
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                            @endfor
                        </div>

                        @foreach($days as $day)
                            @php
                                $dateKey = $day->toDateString();
                                $dayEvents = $eventsByDate->get($dateKey, collect());
                                $isWeekend = in_array($day->dayOfWeekIso, [6,7]);
                            @endphp

                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full {{ $isWeekend ? 'bg-gray-50/20 dark:bg-gray-800/20' : '' }}">
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
                                        <p class="mt-1 text-[10px] text-text-secondary truncate">
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
            <div class="text-sm text-text-secondary text-center py-6">
                Tidak ada jadwal pada minggu ini dengan filter yang dipilih.
            </div>
        @endif

    </div>

</div>
</x-master>
