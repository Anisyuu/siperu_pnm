{{--
    =====================================================
    BREADCRUMB TIMELINE COMPONENT
    =====================================================
    Cara pakai:

    1. Halaman Kampus (index):
       <x-breadcrumb :steps="[
           ['label' => 'Kampus', 'active' => true],
       ]"/>

    2. Halaman Gedung:
       <x-breadcrumb :steps="[
           ['label' => 'Kampus', 'url' => route('kasubag.kampus.index')],
           ['label' => 'Gedung', 'active' => true],
       ]"/>

    3. Halaman Ruangan (dengan lantai):
       <x-breadcrumb :steps="[
           ['label' => 'Kampus',  'url' => route('kasubag.kampus.index'),                                        'subtitle' => $gedung->kampus->nama_kampus],
           ['label' => 'Gedung',  'url' => route('kasubag.gedung.index', $gedung->kampus->nama_kampus),          'subtitle' => $gedung->nama_gedung],
           ['label' => 'Lantai',  'url' => route('kasubag.ruangan.index', [$gedung->id, $lantai]),               'subtitle' => 'Lantai '.$lantai],
           ['label' => 'Ruangan', 'active' => true],
       ]"/>
    =====================================================
--}}

@props([
    'steps' => []
])

<nav aria-label="breadcrumb" class="mb-8 min-w-full ">
    <div class="inline-flex items-center bg-white rounded-2xl px-5 py-3 gap-0">

        @foreach($steps as $i => $step)

        {{-- ── STEP NODE ── --}}
        <div class="flex items-center gap-0">

            {{-- Circle + Label --}}
            <div class="flex items-center gap-2.5 group">

                {{-- Number Circle --}}
                @if($step['active'] ?? false)
                    {{-- Active Step --}}
                    <div class="relative flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white text-xs font-bold  shrink-0">
                        {{ $i + 1 }}
                        {{-- Pulse ring --}}
                        <span class="absolute inset-0 rounded-full bg-blue-400 animate-ping opacity-20"></span>
                    </div>
                @elseif(isset($step['url']))
                    {{-- Completed / Clickable Step --}}
                    <a href="{{ $step['url'] }}"
                       class="relative flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold border-2 border-emerald-200 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all duration-200 shrink-0 ">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </a>
                @else
                    {{-- Disabled Step --}}
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-400 text-xs font-bold border-2 border-slate-200 shrink-0">
                        {{ $i + 1 }}
                    </div>
                @endif

                {{-- Label + Subtitle --}}
                <div class="flex flex-col leading-none">
                    @if(isset($step['url']))
                        <a href="{{ $step['url'] }}"
                           class="text-xs font-bold text-slate-400 hover:text-primary transition-colors duration-150 uppercase tracking-wider">
                            {{ $step['label'] }}
                        </a>
                    @elseif($step['active'] ?? false)
                        <span class="text-xs font-bold text-primary uppercase tracking-wider">
                            {{ $step['label'] }}
                        </span>
                    @else
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">
                            {{ $step['label'] }}
                        </span>
                    @endif

                </div>

            </div>

            {{-- ── CONNECTOR LINE (not on last item) ── --}}
            @if(!$loop->last)
            <div class="flex items-center mx-3">
                @php
                    $nextStep   = $steps[$i + 1];
                    $isDone     = isset($step['url']) || ($step['active'] ?? false);
                    $lineColor  = $isDone ? 'bg-slate-200' : 'bg-slate-100';
                @endphp
                <div class="flex items-center gap-1">
                    <div class="w-6 h-px {{ $lineColor }}"></div>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                    <div class="w-6 h-px {{ $lineColor }}"></div>
                </div>
            </div>
            @endif

        </div>

        @endforeach

    </div>
</nav>