{{-- jadwal-ruangan.blade.php --}}
<x-master>
@php
    $startHour  = 0;
    $endHour    = 23;
    $slotHeight = 60;        //px per jam
    $totalSlots = ($endHour - $startHour + 1) * 2; // per 30 menit

    $prevWeek = $weekStart->copy()->subDays(7)->toDateString();
    $nextWeek = $weekStart->copy()->addDays(7)->toDateString();

    $colorMap = [
        'jadwal' => [
            'bg'     => 'background:#dbeafe',
            'border' => 'border-left:3px solid #3b82f6',
            'title'  => 'color:#1e40af',
            'meta'   => 'color:#3b82f6',
        ],
        'peminjaman' => [
            'bg'     => 'background:#d1fae5',
            'border' => 'border-left:3px solid #10b981',
            'title'  => 'color:#065f46',
            'meta'   => 'color:#10b981',
        ],
    ];
@endphp

<div class="min-h-screen px-6 py-8">
<div class="mx-auto max-w-7xl space-y-6">

    {{-- ======== HEADER ======== --}}
    <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Jadwal Ruangan</h1>
            <p class="mt-0.5 text-sm text-slate-500">Lihat dan filter jadwal penggunaan ruangan</p>
        </div>
        <span class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm">
            <svg class="size-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
            </svg>
            {{ now()->locale('id')->translatedFormat('d F Y') }}
        </span>
    </div>

    {{-- ======== FILTER ======== --}}
    <form method="GET" action="{{ url()->current() }}"
          class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end">

            {{-- Ruangan --}}
            <div class="flex flex-1 flex-col gap-1">
                <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Ruangan
                </label>
                <select name="ruangan_id"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Ruangan</option>
                    @foreach($ruangan as $r)
                        <option value="{{ $r->id }}" @selected(request('ruangan_id') == $r->id)>
                            {{ $r->nama_ruang ?? $r->nama ?? 'Ruangan #'.$r->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="flex flex-1 flex-col gap-1">
                <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Tanggal
                </label>
                <input type="date" name="tanggal"
                       value="{{ request('tanggal', $weekStart->toDateString()) }}"
                       class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>

            {{-- Cari --}}
            <div class="flex flex-1 flex-col gap-1">
                <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Cari
                </label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                           placeholder="Mata kuliah / Dosen / Catatan"
                           class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex shrink-0 gap-2">
                <button type="submit"
                        class="rounded-xl bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:brightness-110 active:scale-95">
                    Terapkan
                </button>
                <a href="{{ url()->current() }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-500 transition hover:bg-slate-50">
                    Reset
                </a>
            </div>

        </div>
    </form>

    {{-- ======== KALENDER ======== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Toolbar navigasi minggu --}}
        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">

            {{-- Legend --}}
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="inline-block size-2.5 rounded-sm bg-blue-400"></span>
                    Jadwal Kuliah
                </span>
                <span class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="inline-block size-2.5 rounded-sm bg-emerald-400"></span>
                    Peminjaman
                </span>
            </div>

            {{-- Nav minggu --}}
            <div class="flex items-center gap-1 rounded-xl border border-slate-200 px-2 py-1.5">
                <a href="{{ url()->current().'?'.http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $prevWeek])) }}"
                   class="flex size-7 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </a>

                <span class="min-w-[120px] text-center text-sm font-semibold text-slate-800">
                    {{ $monthLabel }}
                </span>

                <a href="{{ url()->current().'?'.http_build_query(array_merge(request()->except('tanggal'), ['tanggal' => $nextWeek])) }}"
                   class="flex size-7 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

        </div>

        {{-- Day header --}}
        <div class="flex border-b border-slate-200 bg-slate-50">
            {{-- Spacer kolom jam --}}
            <div class="w-14 shrink-0 border-r border-slate-200"></div>

            <div class="grid flex-1 grid-cols-7">
                @foreach($days as $day)
                    @php
                        $isToday   = $day->isSameDay(now());
                        $isWeekend = in_array($day->dayOfWeekIso, [6, 7]);
                    @endphp
                    <div class="border-r border-slate-200 px-1 py-2.5 text-center last:border-r-0
                                {{ $isToday ? 'bg-blue-50' : '' }}">
                        <p class="mb-1 text-[11px] font-semibold uppercase tracking-wider
                                  {{ $isWeekend ? 'text-rose-400' : ($isToday ? 'text-primary' : 'text-slate-400') }}">
                            {{ $day->locale('id')->translatedFormat('D') }}
                        </p>
                        @if($isToday)
                            <div class="mx-auto flex size-8 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                                {{ $day->format('d') }}
                            </div>
                        @else
                            <div class="mx-auto flex size-8 items-center justify-center rounded-full text-sm font-semibold
                                        {{ $isWeekend ? 'text-slate-400' : 'text-slate-700' }}
                                        hover:bg-slate-100 transition cursor-default">
                                {{ $day->format('d') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Scrollable body --}}
        <div class="h-[540px] overflow-y-auto">
            <div class="flex">

                {{-- Kolom jam --}}
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

                {{-- Grid 7 hari --}}
                <div class="relative grid flex-1 grid-cols-7"
                     style="min-height: {{ ($endHour - $startHour + 1) * $slotHeight }}px">

                    {{-- Garis jam (background) --}}
                    <div class="pointer-events-none absolute inset-0 flex flex-col">
                        @for($i = 0; $i <= ($endHour - $startHour); $i++)
                            @php $isHalfHour = false; @endphp
                            <div class="border-b border-slate-100" style="height:{{ $slotHeight / 2 }}px"></div>
                            <div class="border-b border-slate-100/60 border-dashed" style="height:{{ $slotHeight / 2 }}px"></div>
                        @endfor
                    </div>

                    {{-- Kolom per hari --}}
                    @foreach($days as $day)
                        @php
                            $dateKey   = $day->toDateString();
                            $dayEvents = $eventsByDate->get($dateKey, collect());
                            $isWeekend = in_array($day->dayOfWeekIso, [6, 7]);
                            $isToday   = $day->isSameDay(now());
                        @endphp
                        <div class="relative border-r border-slate-200 last:border-r-0 h-full
                                    {{ $isWeekend ? 'bg-slate-50/60' : '' }}
                                    {{ $isToday   ? 'bg-blue-50/20' : '' }}">

                            @foreach($dayEvents as $ev)
                                @php
                                    $start    = \Carbon\Carbon::parse($ev['waktu_mulai']);
                                    $end      = \Carbon\Carbon::parse($ev['waktu_selesai']);
                                    $startMin = $start->hour * 60 + $start->minute;
                                    $endMin   = $end->hour   * 60 + $end->minute;
                                    $topPx    = ($startMin / 30) * ($slotHeight / 2);
                                    $heightPx = max(22, (($endMin - $startMin) / 30) * ($slotHeight / 2));
                                    $type     = $ev['type'] ?? 'jadwal';
                                    $color    = $colorMap[$type] ?? $colorMap['jadwal'];
                                    $short    = $heightPx < 40;
                                @endphp

                                <div class="group absolute inset-x-0.5 overflow-hidden rounded-md px-1.5 py-1 transition hover:brightness-95"
                                     style="top:{{ $topPx }}px; height:{{ $heightPx }}px;
                                            {{ $color['bg'] }}; {{ $color['border'] }}">

                                    {{-- Title --}}
                                    <p class=" text-[11px] font-semibold leading-tight"
                                       style="{{ $color['title'] }}">
                                        {{ $ev['title'] }}
                                    </p>

                                    {{-- Waktu + subtitle — sembunyikan jika event terlalu kecil --}}
                                    @unless($short)
                                        <p class="mt-0.5 text-[10px] font-medium leading-tight tabular-nums"
                                           style="{{ $color['meta'] }}">
                                            {{ $start->format('H:i') }}–{{ $end->format('H:i') }}
                                        </p>
                                        @if(!empty($ev['subtitle']))
                                            <p class="mt-0.5  text-[10px] leading-tight text-slate-500">
                                                {{ $ev['subtitle'] }}
                                            </p>
                                        @endif
                                    @endunless
                                </div>
                            @endforeach

                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Empty state --}}
        @if($events->count() === 0)
            <div class="flex flex-col items-center gap-2 border-t border-slate-200 py-12 text-center">
                <svg class="size-10 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12V9Zm0 3h.008v.008H12v-.008Zm0 3h.008v.008H12v-.008Zm-3-6h.008v.008H9V9Zm0 3h.008v.008H9v-.008Zm0 3h.008v.008H9v-.008Zm6-6h.008v.008h-.008V9Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
                <p class="text-sm font-medium text-slate-500">Tidak ada jadwal minggu ini</p>
                <p class="text-xs text-slate-400">Coba ubah filter atau pilih minggu lain</p>
            </div>
        @endif

    </div>
    {{-- /kalender --}}

</div>
</div>
</x-master>
