<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    Selamat Datang, {{ auth()->user()->nama_lengkap }}!
                </h2>
                <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span id="realtime-date"></span>
                </div>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-layer-group text-slate-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Permohonan</p>
                    <p class="text-xl font-extrabold text-slate-800">{{ $total }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-hourglass-half text-amber-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Perlu Diverifikasi</p>
                    <p class="text-xl font-extrabold text-slate-800">{{ $menunggu }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-green-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Telah Disetujui</p>
                    <p class="text-xl font-extrabold text-slate-800">{{ $disetujui }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-xmark text-red-400 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Telah Ditolak</p>
                    <p class="text-xl font-extrabold text-slate-800">{{ $ditolak }}</p>
                </div>
            </div>

        </div>

        {{-- KALENDER --}}
        @php
            $startHour  = 0;
            $endHour    = 23;
            $slotHeight = 60;

            $prevWeek = $weekStart->copy()->subDays(7)->toDateString();
            $nextWeek = $weekStart->copy()->addDays(7)->toDateString();

            $roomColorPalette = [
                ['bg' => '#fff1f2', 'border' => '#fb7185', 'title' => '#be123c', 'meta' => '#e11d48'],
                ['bg' => '#fff7ed', 'border' => '#fb923c', 'title' => '#c2410c', 'meta' => '#ea580c'],
                ['bg' => '#fefce8', 'border' => '#facc15', 'title' => '#a16207', 'meta' => '#ca8a04'],
                ['bg' => '#ecfccb', 'border' => '#84cc16', 'title' => '#3f6212', 'meta' => '#65a30d'],
                ['bg' => '#dcfce7', 'border' => '#22c55e', 'title' => '#166534', 'meta' => '#16a34a'],
                ['bg' => '#ecfeff', 'border' => '#06b6d4', 'title' => '#0e7490', 'meta' => '#0891b2'],
                ['bg' => '#eff6ff', 'border' => '#3b82f6', 'title' => '#1d4ed8', 'meta' => '#2563eb'],
                ['bg' => '#eef2ff', 'border' => '#6366f1', 'title' => '#4338ca', 'meta' => '#4f46e5'],
                ['bg' => '#f5f3ff', 'border' => '#8b5cf6', 'title' => '#6d28d9', 'meta' => '#7c3aed'],
                ['bg' => '#fdf4ff', 'border' => '#d946ef', 'title' => '#a21caf', 'meta' => '#c026d3'],
            ];

            $getRoomColor = function ($roomName) use ($roomColorPalette) {
                $index = abs(crc32((string) $roomName)) % count($roomColorPalette);
                return $roomColorPalette[$index];
            };
        @endphp

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 border-b border-slate-200 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Jadwal Penggunaan Ruangan</h3>
                    <p class="mt-0.5 text-xs text-slate-400">Warna berbeda menandai ruangan yang sedang terpakai.</p>
                </div>
                <div class="flex items-center gap-1 rounded-xl border border-slate-200 px-2 py-1.5">
                    <a href="{{ url()->current().'?'.http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $prevWeek])) }}"
                       class="flex size-7 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                    <span class="min-w-[120px] text-center text-sm font-semibold text-slate-800">{{ $monthLabel }}</span>
                    <a href="{{ url()->current().'?'.http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $nextWeek])) }}"
                       class="flex size-7 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Header Hari --}}
            <div class="flex border-b border-slate-200 bg-slate-50">
                <div class="w-14 shrink-0 border-r border-slate-200"></div>
                <div class="grid flex-1 grid-cols-7">
                    @foreach($days as $day)
                        @php
                            $isToday   = $day->isSameDay(now());
                            $isWeekend = in_array($day->dayOfWeekIso, [6, 7]);
                        @endphp
                        <div class="border-r border-slate-200 px-1 py-2.5 text-center last:border-r-0 {{ $isToday ? 'bg-blue-50' : '' }}">
                            <p class="mb-1 text-[11px] font-semibold uppercase tracking-wider
                                {{ $isWeekend ? 'text-rose-400' : ($isToday ? 'text-primary' : 'text-slate-400') }}">
                                {{ $day->locale('id')->translatedFormat('D') }}
                            </p>
                            @if($isToday)
                                <div class="mx-auto flex size-8 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                                    {{ $day->format('d') }}
                                </div>
                            @else
                                <div class="mx-auto flex size-8 items-center justify-center rounded-full text-sm font-semibold {{ $isWeekend ? 'text-slate-400' : 'text-slate-700' }}">
                                    {{ $day->format('d') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Body Kalender --}}
            <div class="h-[540px] overflow-y-auto">
                <div class="flex">

                    {{-- Kolom Jam --}}
                    <div class="sticky left-0 z-10 w-14 shrink-0 border-r border-slate-200 bg-white">
                        @for($t = $startHour * 60; $t <= $endHour * 60; $t += 30)
                            @php $h = floor($t / 60); $m = $t % 60; @endphp
                            <div class="relative flex h-[30px] items-start justify-end border-b border-slate-100 pr-2">
                                @if($m === 0)
                                    <span class="absolute -top-2 right-2 bg-white px-0.5 text-[10px] text-slate-400 tabular-nums">
                                        {{ sprintf('%02d:00', $h) }}
                                    </span>
                                @endif
                            </div>
                        @endfor
                    </div>

                    {{-- Grid 7 Hari --}}
                    <div class="relative grid flex-1 grid-cols-7"
                         style="min-height: {{ ($endHour - $startHour + 1) * $slotHeight }}px">

                        {{-- Garis Jam --}}
                        <div class="pointer-events-none absolute inset-0 flex flex-col">
                            @for($i = 0; $i <= ($endHour - $startHour); $i++)
                                <div class="border-b border-slate-100" style="height:{{ $slotHeight / 2 }}px"></div>
                                <div class="border-b border-slate-100/60 border-dashed" style="height:{{ $slotHeight / 2 }}px"></div>
                            @endfor
                        </div>

                        {{-- Kolom Per Hari --}}
                        @foreach($days as $day)
                            @php
                                $dateKey   = $day->toDateString();
                                $dayEvents = $eventsByDate->get($dateKey, collect());
                                $isWeekend = in_array($day->dayOfWeekIso, [6, 7]);
                                $isToday   = $day->isSameDay(now());
                            @endphp

                            <div class="relative border-r border-slate-200 last:border-r-0 h-full
                                {{ $isWeekend ? 'bg-slate-50/60' : '' }}
                                {{ $isToday ? 'bg-blue-50/20' : '' }}">

                                @foreach($dayEvents as $ev)
                                    @php
                                        $start = \Carbon\Carbon::parse($ev['waktu_mulai']);
                                        $end   = \Carbon\Carbon::parse($ev['waktu_selesai']);

                                        $startMin = $start->hour * 60 + $start->minute;
                                        $endMin   = $end->hour * 60 + $end->minute;

                                        $topPx    = ($startMin / 30) * ($slotHeight / 2);
                                        $heightPx = max(22, (($endMin - $startMin) / 30) * ($slotHeight / 2));

                                        $roomColor    = $getRoomColor($ev['ruangan'] ?? $ev['title'] ?? '-');
                                        $short        = $heightPx < 42;
                                        $overlapTotal = $ev['overlap_total'] ?? 1;
                                        $overlapIndex = $ev['overlap_index'] ?? 0;
                                        $widthPercent = 100 / $overlapTotal;
                                        $leftPercent  = $widthPercent * $overlapIndex;

                                        $evData = json_encode([
                                            'type'        => $ev['type'],
                                            'ruangan'     => $ev['ruangan'] ?? '-',
                                            'title'       => $ev['title'] ?? '-',
                                            'subtitle'    => $ev['subtitle'] ?? '-',
                                            'tanggal'     => \Carbon\Carbon::parse($ev['tanggal'])->locale('id')->translatedFormat('l, d F Y'),
                                            'mulai'       => $start->format('H:i'),
                                            'selesai'     => $end->format('H:i'),
                                            'bg'          => $roomColor['bg'],
                                            'border'      => $roomColor['border'],
                                            'title_color' => $roomColor['title'],
                                            'meta_color'  => $roomColor['meta'],
                                        ]);
                                    @endphp

                                    {{-- EVENT DIV --}}
                                    <div class="group absolute overflow-hidden rounded-md px-1.5 py-1 transition hover:brightness-95 cursor-pointer"
                                         style="
                                             top: {{ $topPx }}px;
                                             height: {{ $heightPx }}px;
                                             left: calc({{ $leftPercent }}% + 2px);
                                             width: calc({{ $widthPercent }}% - 4px);
                                             background: {{ $roomColor['bg'] }};
                                             border-left: 3px solid {{ $roomColor['border'] }};
                                         "
                                         onclick='openDetailModal({{ $evData }})'>

                                        <p class="text-[11px] font-semibold leading-tight truncate"
                                           style="color:{{ $roomColor['title'] }}">
                                            {{ $ev['ruangan'] ?? '-' }}
                                        </p>

                                        @unless($short)
                                            <p class="mt-0.5 text-[10px] font-medium leading-tight tabular-nums"
                                               style="color:{{ $roomColor['meta'] }}">
                                                {{ $start->format('H:i') }}–{{ $end->format('H:i') }}
                                            </p>
                                            <p class="mt-0.5 text-[10px] leading-tight text-slate-600 truncate">
                                                {{ $ev['title'] ?? '-' }}
                                            </p>
                                        @endunless
                                    </div>
                                @endforeach

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- Empty State --}}
            @if($events->count() === 0)
                <div class="flex flex-col items-center gap-2 border-t border-slate-200 py-12 text-center">
                    <svg class="size-10 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                    </svg>
                    <p class="text-sm font-medium text-slate-500">Tidak ada penggunaan ruangan minggu ini</p>
                    <p class="text-xs text-slate-400">Coba pilih minggu lain</p>
                </div>
            @endif

        </div>

    </div>
</div>

{{-- MODAL DETAIL EVENT — di luar kalender, satu instance saja --}}
<div id="event-detail-modal"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4"
     onclick="closeDetailModalFromBackdrop(event)">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">

        <div id="modal-header" class="px-5 py-4 flex items-start justify-between gap-3">
            <div class="flex items-center gap-3">
                <div id="modal-icon" class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i id="modal-icon-i" class="text-base"></i>
                </div>
                <div>
                    <p id="modal-type-label" class="text-[10px] font-bold uppercase tracking-wider"></p>
                    <p id="modal-ruangan" class="text-base font-extrabold text-slate-800 leading-tight"></p>
                </div>
            </div>
            <button onclick="closeDetailModal()"
                    class="mt-0.5 flex-shrink-0 text-slate-400 hover:text-slate-600 transition">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="modal-divider" class="h-px mx-5"></div>

        <div class="px-5 py-4 flex flex-col gap-3">

            <div class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal</p>
                    <p id="modal-tanggal" class="text-sm font-semibold text-slate-700"></p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-regular fa-clock text-slate-400 text-xs"></i>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Waktu</p>
                    <p id="modal-waktu" class="text-sm font-semibold text-slate-700"></p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-tag text-slate-400 text-xs"></i>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Kegiatan</p>
                    <p id="modal-title" class="text-sm font-semibold text-slate-700"></p>
                </div>
            </div>

            <div id="modal-subtitle-row" class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-user text-slate-400 text-xs"></i>
                </div>
                <div>
                    <p id="modal-subtitle-label" class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider"></p>
                    <p id="modal-subtitle" class="text-sm font-semibold text-slate-700"></p>
                </div>
            </div>

        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateDate() {
            const now   = new Date();
            const hari  = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
            const bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli",
                           "Agustus","September","Oktober","November","Desember"];
            const el = document.getElementById("realtime-date");
            if (el) el.textContent =
                `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
        }
        updateDate();
        setInterval(updateDate, 60000);
    });

    function openDetailModal(ev) {
        const modal    = document.getElementById('event-detail-modal');
        const isJadwal = ev.type === 'jadwal';

        document.getElementById('modal-header').style.background   = ev.bg;
        document.getElementById('modal-divider').style.background  = ev.border;
        document.getElementById('modal-icon').style.background     = ev.border + '33';

        const iconI = document.getElementById('modal-icon-i');
        iconI.className = isJadwal ? 'fa-solid fa-calendar-check text-base' : 'fa-solid fa-key text-base';
        iconI.style.color = ev.title_color;

        const typeLabel = document.getElementById('modal-type-label');
        typeLabel.textContent = isJadwal ? 'Jadwal Ruangan' : 'Peminjaman Ruangan';
        typeLabel.style.color = ev.meta_color;

        document.getElementById('modal-ruangan').textContent = ev.ruangan;
        document.getElementById('modal-tanggal').textContent = ev.tanggal;
        document.getElementById('modal-waktu').textContent   = ev.mulai + ' – ' + ev.selesai + ' WIB';
        document.getElementById('modal-title').textContent   = ev.title;

        const subtitleRow   = document.getElementById('modal-subtitle-row');
        const subtitleLabel = document.getElementById('modal-subtitle-label');
        const subtitleEl    = document.getElementById('modal-subtitle');

        if (ev.subtitle && ev.subtitle !== '-' && ev.subtitle !== '') {
            subtitleRow.classList.remove('hidden');
            subtitleLabel.textContent = isJadwal ? 'Penanggung Jawab' : 'Kegiatan';
            subtitleEl.textContent    = ev.subtitle;
        } else {
            subtitleRow.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDetailModal() {
        const modal = document.getElementById('event-detail-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function closeDetailModalFromBackdrop(event) {
        if (event.target.id === 'event-detail-modal') closeDetailModal();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDetailModal();
    });
</script>
@endpush

</x-master>
