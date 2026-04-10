<x-master>
    @php
        $slotHeight = 80;
        $totalHours = ($endHour - $startHour) + 1;

        $prevWeekTanggal = $weekStart->copy()->subDays(7)->toDateString();
        $nextWeekTanggal = $weekStart->copy()->addDays(7)->toDateString();

        $palette = [
            ['bg' => 'bg-primary/10', 'border' => 'border-primary', 'title' => 'text-primary', 'time' => 'text-primary/80'],
            ['bg' => 'bg-purple-100', 'border' => 'border-purple-500', 'title' => 'text-purple-700', 'time' => 'text-purple-600'],
            ['bg' => 'bg-orange-100', 'border' => 'border-orange-500', 'title' => 'text-orange-700', 'time' => 'text-orange-600'],
            ['bg' => 'bg-emerald-100', 'border' => 'border-emerald-500', 'title' => 'text-emerald-700', 'time' => 'text-emerald-600'],
        ];
    @endphp

    <div class="bg-slate-100 min-h-screen px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                        Selamat Datang, {{ auth()->user()->nama_lengkap }}!
                    </h2>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span id="realtime-date"></span>
                    </div>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- CARD 1 --}}
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-regular fa-calendar-days text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peminjaman Aktif</p>
                        <p class="text-xl font-extrabold text-slate-800">8</p>
                    </div>
                </div>

                {{-- CARD 2 --}}
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-clock-rotate-left text-amber-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Persetujuan</p>
                        <p class="text-xl font-extrabold text-slate-800">3</p>
                    </div>
                </div>

                {{-- CARD 3 --}}
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-calendar-xmark text-red-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pengajuan Ditolak</p>
                        <p class="text-xl font-extrabold text-slate-800">1</p>
                    </div>
                </div>

            </div>

            {{-- KALENDER --}}
            <div class="flex flex-col gap-4">

                {{-- CONTROL --}}
                <div class="flex justify-end">
                    <div class="flex items-center bg-white rounded-xl border border-slate-200 px-3 py-1.5 shadow-sm">
                        <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $prevWeekTanggal])) }}"
                           class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors text-slate-500">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>

                        <span class="px-4 text-sm font-bold text-slate-800">
                            {{ $monthLabel }}
                        </span>

                        <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $nextWeekTanggal])) }}"
                           class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors text-slate-500">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>

                        <div class="w-px h-4 bg-slate-200 mx-2"></div>

                        <button type="button" class="px-3 py-1 text-xs font-bold bg-primary text-white rounded-lg shadow-sm">
                            Minggu
                        </button>
                        <button type="button" disabled
                                class="px-3 py-1 text-xs font-medium text-slate-400 rounded-lg opacity-50 cursor-not-allowed">
                            Bulan
                        </button>
                    </div>
                </div>

                {{-- CALENDAR --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[500px]">

                    {{-- HEADER HARI --}}
                    <div class="flex border-b border-slate-200 bg-slate-50/60 z-20">
                        <div class="w-16 shrink-0 border-r border-slate-200 flex items-center justify-center p-2">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">GMT+7</span>
                        </div>

                        <div class="flex-1 overflow-hidden">
                            <div class="grid grid-cols-7 w-full min-w-[700px]">
                                @foreach($days as $day)
                                    @php
                                        $isToday   = $day->isSameDay(now());
                                        $isWeekend = in_array($day->dayOfWeekIso, [6, 7]);
                                        $abbr      = $day->locale('id')->translatedFormat('D');
                                    @endphp

                                    <div class="p-3 border-r border-slate-200 text-center
                                        {{ $isToday ? 'bg-primary/5' : ($isWeekend ? 'bg-slate-50/70' : 'group cursor-pointer hover:bg-slate-50 transition-colors') }}">

                                        <p class="text-xs mb-1
                                            {{ $isWeekend ? 'text-red-400 font-medium' : ($isToday ? 'text-primary font-bold' : 'text-slate-400 font-bold group-hover:text-primary') }}">
                                            {{ $abbr }}
                                        </p>

                                        @if($isToday)
                                            <div class="size-8 mx-auto flex items-center justify-center bg-primary text-white rounded-full font-bold text-sm shadow-md">
                                                {{ $day->format('d') }}
                                            </div>
                                        @else
                                            <div class="size-8 mx-auto flex items-center justify-center font-bold text-sm
                                                {{ $isWeekend ? 'text-slate-400' : 'text-slate-800' }}">
                                                {{ $day->format('d') }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="flex-1 overflow-y-auto relative custom-scrollbar">
                        <div class="flex min-h-[600px]">

                            {{-- TIME --}}
                            <div class="w-16 shrink-0 flex flex-col border-r border-slate-200 bg-white sticky left-0 z-10">
                                @for($time = $startHour * 60; $time <= $endHour * 60; $time += 30)
                                    @php
                                        $hour   = floor($time / 60);
                                        $minute = $time % 60;
                                    @endphp
                                    <div class="h-10 border-b border-slate-200/70 text-[10px] text-slate-400 p-1 text-center relative">
                                        <span class="-top-2 relative bg-white px-1">
                                            {{ sprintf('%02d:%02d', $hour, $minute) }}
                                        </span>
                                    </div>
                                @endfor
                            </div>

                            {{-- GRID --}}
                            <div class="flex-1 min-w-[700px] grid grid-cols-7 relative bg-white"
                                 style="min-height: {{ $totalHours * $slotHeight }}px;">

                                <div class="absolute inset-0 flex flex-col pointer-events-none">
                                    @for($i = 0; $i < $totalHours; $i++)
                                        <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    @endfor
                                </div>

                                @foreach($days as $day)
                                    @php
                                        $dateKey   = $day->toDateString();
                                        $dayEvents = $eventsByDate->get($dateKey, collect());
                                        $isWeekend = in_array($day->dayOfWeekIso, [6, 7]);
                                    @endphp

                                    <div class="border-r border-slate-200 relative h-full {{ $isWeekend ? 'bg-slate-50/50' : '' }}">
                                        @foreach($dayEvents as $ev)
                                            @php
                                                $start = \Illuminate\Support\Carbon::parse($ev->waktu_mulai);
                                                $end   = \Illuminate\Support\Carbon::parse($ev->waktu_selesai);

                                                $startMinutes = ($start->hour * 60 + $start->minute) - ($startHour * 60);
                                                $endMinutes   = ($end->hour * 60 + $end->minute) - ($startHour * 60);
                                                $startMinutes = max(0, $startMinutes);
                                                $endMinutes   = min($totalHours * 60, $endMinutes);

                                                $duration = max(15, $endMinutes - $startMinutes);
                                                $topPx    = ($startMinutes / 60) * $slotHeight;
                                                $heightPx = ($duration / 60) * $slotHeight;

                                                $idx = ($ev->ruangan_id ?? 0) % count($palette);
                                                $c   = $palette[$idx];

                                                $title    = $ev->mata_kuliah;
                                                $timeText = $start->format('H:i') . ' - ' . $end->format('H:i');
                                            @endphp

                                            <div class="absolute left-1 right-1 rounded-lg p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm {{ $c['bg'] }} border-l-4 {{ $c['border'] }}"
                                                 style="top: {{ $topPx }}px; height: {{ $heightPx }}px;">
                                                <p class="text-[11px] font-bold truncate {{ $c['title'] }}">{{ $title }}</p>
                                                <p class="text-[10px] truncate {{ $c['time'] }}">{{ $timeText }}</p>
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

    @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function updateDate() {
                    const now = new Date();
                    const hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
                    const bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                    document.getElementById("realtime-date").textContent =
                        `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
                }
                updateDate();
                setInterval(updateDate, 60000);
            });
        </script>
    @endpush
</x-master>
