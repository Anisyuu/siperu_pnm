<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Penggunaan Sistem Informasi Peminjaman Ruangan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: Inter, Arial, sans-serif;
        }

        .step-connector::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 32px;
            bottom: -24px;
            width: 1px;
            background: linear-gradient(to bottom, #c7d2fe, transparent);
        }

        /* LIGHTBOX */
        #lightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        #lightbox.active {
            display: flex;
        }

        #lightbox-img {
            max-width: 90vw;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            animation: zoomIn .18s ease;
        }

        #lightbox-caption {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            font-size: 12px;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 999px;
            backdrop-filter: blur(8px);
            white-space: nowrap;
        }

        #lightbox-close {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            transition: background .15s;
        }

        #lightbox-close:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .zoomable {
            cursor: zoom-in;
            transition: opacity .15s;
        }

        .zoomable:hover {
            opacity: 0.88;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.93);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-slate-50">

    {{-- LIGHTBOX MODAL --}}
    <div id="lightbox" role="dialog" aria-modal="true" aria-label="Zoom gambar">
        <button id="lightbox-close" onclick="closeLightbox()" aria-label="Tutup" type="button">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img id="lightbox-img" src="" alt="">
        <div id="lightbox-caption"></div>
    </div>

    <div class="min-h-screen px-6 py-6">

        {{-- HEADER --}}
        <div class="mb-6 bg-white border border-slate-200 rounded-2xl px-6 py-5 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="flex-1">
                <h1 class="text-xl font-black text-slate-900 flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-open text-white text-sm"></i>
                    </span>

                    Panduan Penggunaan Sistem
                </h1>

                <p class="text-sm text-slate-500 mt-1 ml-11 leading-6">
                    Panduan ini berisi langkah penggunaan sistem berdasarkan role pengguna pada Sistem Informasi Peminjaman Ruangan.
                </p>

                {{-- INFORMASI ROLE --}}
                <div class="mt-4 ml-11 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-user-tie text-blue-600 text-sm"></i>
                            <p class="text-sm font-bold text-slate-800">Kasubag</p>
                        </div>
                        <p class="text-xs text-slate-600 leading-5">
                            Pengguna yang mengelola data utama sistem, seperti pengguna, ruangan, jadwal, alur verifikasi, serta dapat melakukan verifikasi dan melihat riwayat.
                        </p>
                    </div>

                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-user-check text-emerald-600 text-sm"></i>
                            <p class="text-sm font-bold text-slate-800">Verifikator</p>
                        </div>
                        <p class="text-xs text-slate-600 leading-5">
                            Pengguna yang bertugas memproses pengajuan peminjaman, seperti Kalab, Sarpras, Pimpinan, atau role lain yang masuk dalam alur verifikasi.
                        </p>
                    </div>

                    <div class="rounded-xl border border-violet-100 bg-violet-50 px-4 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-user text-violet-600 text-sm"></i>
                            <p class="text-sm font-bold text-slate-800">Pemohon</p>
                        </div>
                        <p class="text-xs text-slate-600 leading-5">
                            Pengguna yang mengajukan peminjaman ruangan, seperti mahasiswa, dosen, karyawan, atau ormawa.
                        </p>
                    </div>
                </div>
            </div>

            {{-- NAVBAR ROLE --}}
            <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl w-fit shrink-0">
                @foreach ($panduan as $roleKey => $roleData)
                    <a href="{{ route('panduan.index', ['role' => $roleKey]) }}"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                        {{ $role === $roleKey
                            ? 'bg-blue-600 text-white shadow-sm shadow-blue-200'
                            : 'text-slate-500 hover:text-slate-800 hover:bg-white/80' }}">

                        <i class="fa-solid {{ $roleData['icon'] }} mr-1.5"></i>
                        {{ $roleData['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- SIDEBAR --}}
            <aside class="w-full lg:w-64 bg-white border border-slate-200 rounded-2xl p-4 h-fit lg:sticky lg:top-6">

                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">
                    {{ $panduan[$role]['label'] }}
                </p>

                <nav class="space-y-0.5">
                    @foreach ($menus as $menuKey => $item)
                        <a href="{{ route('panduan.index', ['role' => $role, 'menu' => $menuKey]) }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                            {{ $menu === $menuKey
                                ? 'bg-blue-50 text-blue-700 border-l-2 border-blue-500 pl-2.5'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 border-l-2 border-transparent pl-2.5' }}">

                            <i class="fa-solid {{ $item['icon'] }} text-xs w-4 shrink-0
                                {{ $menu === $menuKey ? 'text-blue-500' : 'text-slate-400' }}">
                            </i>

                            <span class="leading-tight">
                                <span class="text-[11px] {{ $menu === $menuKey ? 'text-blue-400' : 'text-slate-400' }} font-bold mr-1">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                {{ $item['title'] }}
                            </span>
                        </a>
                    @endforeach
                </nav>
            </aside>

            {{-- KONTEN PANDUAN --}}
            <main class="flex-1 min-w-0">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                    {{-- JUDUL FITUR --}}
                    <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-blue-50/60 to-white">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-200">
                                <i class="fa-solid {{ $activeItem['icon'] }} text-lg"></i>
                            </div>

                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-xs font-semibold text-blue-500 uppercase tracking-wider">
                                        {{ $panduan[$role]['label'] }}
                                    </span>
                                </div>

                                <h2 class="text-xl font-black text-slate-900">
                                    {{ $activeItem['title'] }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    {{-- ISI TUTORIAL --}}
                    <div class="px-8 py-8">

                        <p class="text-sm text-slate-500 leading-7 mb-8 pb-6 border-b border-slate-100">
                            {{ $activeItem['description'] ?? 'Berikut langkah-langkah penggunaan fitur ' . $activeItem['title'] . ' untuk role ' . $panduan[$role]['label'] . '.' }}
                        </p>

                        {{-- FORMAT BARU: DESCRIPTION + SECTIONS --}}
                        @if (isset($activeItem['sections']))
                            <div class="space-y-10">
                                @foreach ($activeItem['sections'] as $section)
                                    <section class="pb-8 border-b border-slate-100 last:border-b-0 last:pb-0">

                                        <h3 class="text-lg font-black text-slate-900 mb-2">
                                            {{ $section['title'] }}
                                        </h3>

                                        @if (!empty($section['description']))
                                            <p class="text-sm md:text-[15px] text-slate-600 leading-7 mb-4">
                                                {{ $section['description'] }}
                                            </p>
                                        @endif

                                        @if (!empty($section['steps']))
                                            <ol class="list-decimal pl-5 space-y-2 text-sm md:text-[15px] text-slate-600 leading-7 mb-5">
                                                @foreach ($section['steps'] as $step)
                                                    <li>{{ $step }}</li>
                                                @endforeach
                                            </ol>
                                        @endif

                                        @if (!empty($section['images']))
                                            <div class="grid gap-4 {{ count($section['images']) > 1 ? 'md:grid-cols-2' : '' }}">
                                                @foreach ($section['images'] as $imageIndex => $imageFile)
                                                    @php
                                                        $caption = $section['image_captions'][$imageIndex] ?? 'Gambar panduan';
                                                    @endphp

                                                    <figure class="border border-slate-200 rounded-2xl bg-slate-50 p-3">
                                                        <img src="{{ asset('assets/' . $imageFile) }}"
                                                            alt="{{ $caption }}"
                                                            class="rounded-xl w-full object-cover zoomable"
                                                            onclick="openLightbox(this.src, '{{ $caption }}')"
                                                            title="Klik untuk memperbesar">

                                                        <figcaption class="text-center text-xs text-slate-400 mt-2.5 font-medium">
                                                            {{ $caption }}
                                                        </figcaption>
                                                    </figure>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if (!empty($section['note']))
                                            <div class="mt-5 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm leading-6 text-blue-800">
                                                <span class="font-bold">Catatan:</span>
                                                {{ $section['note'] }}
                                            </div>
                                        @endif

                                    </section>
                                @endforeach
                            </div>

                        {{-- FORMAT LAMA: STEPS + IMAGES --}}
                        @else
                            <div class="space-y-8">
                                @foreach ($activeItem['steps'] as $step)
                                    @php
                                        $stepNumber = $loop->iteration;
                                        $stepImage = $activeItem['images'][$stepNumber] ?? null;
                                        $isLast = $loop->last;
                                    @endphp

                                    <div class="flex items-start gap-5 relative {{ !$isLast ? 'step-connector' : '' }}">

                                        {{-- NOMOR STEP --}}
                                        <div class="shrink-0 flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black shrink-0 z-10
                                                {{ $loop->first
                                                    ? 'bg-blue-600 text-white shadow-sm shadow-blue-200'
                                                    : 'bg-white border-2 border-slate-200 text-slate-500' }}">
                                                {{ $stepNumber }}
                                            </div>
                                        </div>

                                        {{-- DETAIL STEP --}}
                                        <div class="flex-1 pb-2">

                                            <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-1.5">
                                                Langkah {{ $stepNumber }}
                                            </p>

                                            <p class="text-sm md:text-[15px] text-slate-600 leading-7 mb-4">
                                                {{ $step }}
                                            </p>

                                            @if ($stepImage)
                                                @php
                                                    $stepImages = is_array($stepImage) ? $stepImage : [$stepImage];
                                                @endphp

                                                <div class="w-full max-w-2xl space-y-4">
                                                    @foreach ($stepImages as $imageIndex => $imageFile)
                                                        <div class="border border-slate-200 rounded-2xl bg-slate-50 overflow-hidden">
                                                            <div class="p-3">
                                                                <img src="{{ asset('assets/' . $imageFile) }}"
                                                                    alt="Tutorial {{ $stepNumber }} - {{ $activeItem['title'] }}"
                                                                    class="rounded-xl w-full object-cover zoomable"
                                                                    onclick="openLightbox(this.src, 'Gambar {{ $stepNumber }}{{ count($stepImages) > 1 ? '.' . ($imageIndex + 1) : '' }}. {{ $activeItem['title'] }}')"
                                                                    title="Klik untuk memperbesar">

                                                                <p class="text-center text-xs text-slate-400 mt-2.5 font-medium">
                                                                    Gambar {{ $stepNumber }}{{ count($stepImages) > 1 ? '.' . ($imageIndex + 1) : '' }}.
                                                                    {{ $activeItem['title'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- PREV/NEXT NAVIGATION --}}
                        @php
                            $menuKeys = array_keys($menus);
                            $currentIndex = array_search($menu, $menuKeys);
                            $prevKey = $currentIndex > 0 ? $menuKeys[$currentIndex - 1] : null;
                            $nextKey = $currentIndex < count($menuKeys) - 1 ? $menuKeys[$currentIndex + 1] : null;
                        @endphp

                        <div class="flex items-center justify-between mt-12 pt-6 border-t border-slate-100">
                            @if ($prevKey)
                                <a href="{{ route('panduan.index', ['role' => $role, 'menu' => $prevKey]) }}"
                                    class="flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors group">

                                    <span class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center group-hover:border-blue-300 group-hover:bg-blue-50 transition-all">
                                        <i class="fa-solid fa-arrow-left text-xs"></i>
                                    </span>

                                    <span class="hidden sm:block">
                                        {{ $menus[$prevKey]['title'] }}
                                    </span>
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if ($nextKey)
                                <a href="{{ route('panduan.index', ['role' => $role, 'menu' => $nextKey]) }}"
                                    class="flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors group">

                                    <span class="hidden sm:block">
                                        {{ $menus[$nextKey]['title'] }}
                                    </span>

                                    <span class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center group-hover:border-blue-300 group-hover:bg-blue-50 transition-all">
                                        <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </span>
                                </a>
                            @endif
                        </div>

                    </div>

                </div>
            </main>

        </div>
    </div>

    {{-- LIGHTBOX SCRIPT --}}
    <script>
        function openLightbox(src, caption) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-img').alt = caption;
            document.getElementById('lightbox-caption').textContent = caption;
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.getElementById('lightbox-img').src = '';
            document.body.style.overflow = '';
        }

        document.getElementById('lightbox').addEventListener('click', function (e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>

</body>

</html>
