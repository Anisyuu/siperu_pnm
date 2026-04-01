<x-master>


<div class="bg-slate-100 min-h-screen px-8 py-10">

    @php
        // Cari gedung yang aktif dari gedungList berdasarkan slug
        $activeGedung = $gedungList->first(fn($g) => $g->slug === $gedungSlug);
    @endphp

    <x-breadcrumb :steps="[
        ['label'    => 'Kampus',
         'url'      => route('kasubag.kampus.index'),
         'subtitle' => $activeGedung?->kampus?->nama_kampus ?? 'Kampus'],
        ['label'    => 'Gedung',
         'url'      => route('kasubag.gedung.index', $activeGedung?->kampus?->nama_kampus ?? ''),
         'subtitle' => $activeGedung?->nama ?? 'Gedung'],
        ['label'    => 'Lantai ' . $lantai,
         'url'      => route('kasubag.ruangan.index', [$gedungSlug, $lantai]),
         'subtitle' => 'Lantai ' . $lantai],
        ['label' => 'Ruangan', 'active' => true],
    ]"/>

    {{-- HEADER --}}
    <div class="flex items-start justify-between mb-6 flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Daftar Ruangan</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola dan pantau seluruh ruangan dalam gedung ini.</p>
        </div>
        <button onclick="openModal()"
            class="inline-flex items-center gap-2 bg-primary hover:bg-blue-500 active:scale-95 text-white text-sm font-semibold px-6 py-3 rounded-xl  transition-all duration-200 cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Ruangan
        </button>
    </div>

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ request()->url() }}">
        {{-- Pertahankan parameter URL yang sudah ada (slug gedung & lantai) --}}
        <input type="hidden" name="slug_gedung_url" value="{{ $gedungSlug }}">

        <div class="bg-white rounded-2xl px-5 py-4 mb-5 flex flex-wrap items-center gap-3">

            {{-- Context chips — user selalu tahu sedang lihat mana --}}
            <div class="flex items-center gap-2 flex-wrap">
                <div class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-500 border border-blue-200 text-xs font-bold px-3 py-1.5 rounded-lg">
                    <i class="fa-solid fa-map-pin text-[10px]"></i>
                    {{ $activeGedung?->kampus?->nama_kampus ?? 'Kampus' }}
                </div>
                <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
                <div class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-500  border border-blue-200 text-xs font-bold px-3 py-1.5 rounded-lg">
                    <i class="fa-solid fa-building text-[10px]"></i>
                    {{ $activeGedung?->nama ?? 'Gedung' }}
                </div>
                <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
                <div class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-500 border border-blue-200 text-xs font-bold px-3 py-1.5 rounded-lg">
                    <i class="fa-solid fa-layer-group text-[10px]"></i>
                    Lantai {{ $lantai }}
                </div>
            </div>

            <div class="w-px h-6 bg-slate-200 mx-1"></div>

            {{-- Filter Jenis Ruang — pakai slug sesuai controller --}}
            <div class="flex items-center gap-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Jenis:</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-tags text-xs"></i>
                    </span>
                    <select name="slug_jenis_ruang" onchange="this.form.submit()"
                            class="pl-8 pr-8 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all appearance-none text-slate-700 cursor-pointer">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisRuang as $jr)
                        <option value="{{ $jr->slug }}" {{ request('slug_jenis_ruang') == $jr->slug ? 'selected' : '' }}>
                            {{ $jr->nama_jenis_ruang ?? $jr->nama }}
                        </option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </span>
                </div>
            </div>

            @if(request('slug_jenis_ruang'))
            <a href="{{ request()->url() }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-red-500 bg-slate-100 hover:bg-red-50 px-3 py-2 rounded-xl transition-all">
                <i class="fa-solid fa-rotate-left text-xs"></i> Reset
            </a>
            @endif

            <div class="flex-grow"></div>

            <div class="flex items-center gap-2 text-sm text-slate-500">
                <i class="fa-solid fa-door-open text-blue-400"></i>
                <span>Total: <strong class="text-slate-800">{{ $ruangan->total() }}</strong> ruangan</span>
            </div>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl  overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase w-10">#</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase">Ruangan</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase">No. Ruang</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase">Lantai</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase">Jenis Ruang</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase">Gedung</th>
                        <th class="text-right px-6 py-3.5 text-[11px] font-bold text-slate-400 tracking-widest uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($ruangan as $index => $item)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                        <td class="px-6 py-4 text-slate-400 text-xs font-semibold">
                            {{ $ruangan->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-blue-50 text-blue-500 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-book-open text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->nama_ruang }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">ID: #{{ $item->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center justify-center w-10 h-10 bg-slate-100 text-slate-700 text-sm font-bold rounded-xl border border-slate-200">
                                {{ $item->nomor_ruang }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-layer-group text-blue-400 text-xs"></i>
                                </div>
                                <span class="font-semibold text-slate-700">Lantai {{ $item->lantai }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-500 text-white">
                                <i class="fa-solid fa-tag text-[9px]"></i>
                                {{ $item->jenisRuangan?->nama ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $item->gedung?->nama ?? '-' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i class="fa-solid fa-map-pin text-[9px] text-blue-400"></i>
                                    {{ $item->gedung?->kampus?->nama_kampus ?? '-' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                {{-- Edit: buka modal, set action form --}}
                                <button type="button"
                                        onclick="openEditModal(
                                            {{ $item->id }},
                                            '{{ addslashes($item->nama_ruang) }}',
                                            '{{ $item->nomor_ruang }}',
                                            {{ $item->id_jenis_ruang }}
                                        )"
                                        title="Edit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                {{-- Delete: buka modal konfirmasi --}}
                                <form method="POST" action="{{ route('kasubag.ruangan.destroy', $item->id) }}" onsubmit="return confirmDelete(event, '{{ addslashes($item->nama_ruang) }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            title="Hapus"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center">
                                    <i class="fa-solid fa-door-open text-3xl text-slate-300"></i>
                                </div>
                                <p class="font-semibold text-slate-600">Belum ada ruangan</p>
                                <p class="text-xs text-slate-400">Tambahkan dengan klik <span class="text-blue-500 font-semibold">+ Tambah Ruangan</span>.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($ruangan->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <p class="text-xs text-slate-400">
                Menampilkan
                <span class="font-semibold text-slate-600">{{ $ruangan->firstItem() }}–{{ $ruangan->lastItem() }}</span>
                dari <span class="font-semibold text-slate-600">{{ $ruangan->total() }}</span> ruangan
            </p>
            <div class="flex items-center gap-1">
                @if($ruangan->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 bg-slate-50 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </span>
                @else
                    <a href="{{ $ruangan->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-primary hover:bg-blue-50 border border-slate-200 transition-all">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </a>
                @endif

                @foreach($ruangan->getUrlRange(1, $ruangan->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl text-sm font-semibold transition-all
                        {{ $ruangan->currentPage() === $page ? 'bg-primary text-white ' : 'text-slate-500 hover:text-primary hover:bg-blue-50 border border-slate-200' }}">
                    {{ $page }}
                </a>
                @endforeach

                @if($ruangan->hasMorePages())
                    <a href="{{ $ruangan->nextPageUrl() }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-primary hover:bg-blue-50 border border-slate-200 transition-all">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 bg-slate-50 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL CREATE — route: kasubag.ruangan.store                  --}}
{{-- ============================================================ --}}
<div id="modalRuangan" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal()"></div>
    <div id="modalPanel" class="relative bg-white rounded-2xl  w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0">

        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-primary">
                    <i class="fa-solid fa-door-open text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tambah Ruangan Baru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Lengkapi informasi ruangan di bawah ini</p>
                </div>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="{{ route('kasubag.ruangan.store') }}" method="POST" class="px-6 py-5 space-y-4">
            @csrf

            {{-- Context: user tahu ruangan ini masuk gedung/lantai mana --}}
            <div class="flex flex-wrap gap-2 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                    <i class="fa-solid fa-building text-blue-400"></i>
                    {{ $activeGedung?->nama ?? 'Gedung' }}
                </div>
                <span class="text-slate-300">›</span>
                <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                    <i class="fa-solid fa-layer-group text-violet-400"></i>
                    Lantai {{ $lantai }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Ruang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-door-open text-sm"></i>
                    </span>
                    <input type="text" name="nama_ruang" value="{{ old('nama_ruang') }}"
                           placeholder="Contoh: Ruang Kuliah A" maxlength="25"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border {{ $errors->has('nama_ruang') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-300 transition-all">
                </div>
                @error('nama_ruang')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Ruang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-hashtag text-sm"></i>
                    </span>
                    <input type="text" id="nomor_ruang" name="nomor_ruang"
                           value="{{ old('nomor_ruang') }}"
                           placeholder="A101" maxlength="5"
                           style="text-transform:uppercase"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border {{ $errors->has('nomor_ruang') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-300 transition-all">
                </div>
                @error('nomor_ruang')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Ruang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-tags text-sm"></i>
                    </span>
                    <select name="id_jenis_ruang"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border {{ $errors->has('id_jenis_ruang') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none">
                        <option value="">-- Pilih Jenis Ruang --</option>
                        @foreach($jenisRuang as $jr)
                        <option value="{{ $jr->id }}" {{ old('id_jenis_ruang') == $jr->id ? 'selected' : '' }}>
                            {{ $jr->nama_jenis_ruang ?? $jr->nama }}
                        </option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </div>
                @error('id_jenis_ruang')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Hidden: gedung_slug & lantai dari URL --}}
            <input type="hidden" name="gedung_slug" value="{{ $gedungSlug }}">
            <input type="hidden" name="lantai"      value="{{ $lantai }}">

            <div class="flex items-start gap-2 bg-blue-50 text-primary text-xs rounded-xl px-4 py-3">
                <i class="fa-solid fa-circle-info mt-0.5 shrink-0"></i>
                <span>Kombinasi <strong>Gedung + Lantai + Nomor Ruang</strong> harus unik.</span>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    <i class="fa-solid fa-xmark text-xs"></i> Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-blue-500 rounded-xl transition-all">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Ruangan
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL EDIT — route: kasubag.ruangan.update + @method('PUT') --}}
{{-- action di-set via JS openEditModal()                         --}}
{{-- ============================================================ --}}
<div id="modalEditRuangan" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div id="modalEditPanel" class="relative bg-white rounded-2xl  w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0">

        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Edit Ruangan</h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="editRuanganSubtitle">Perbarui data ruangan</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- action diisi JS: route('kasubag.ruangan.update', $id) --}}
        <form id="formEditRuangan" method="POST" class="px-6 py-5 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="gedung_slug" value="{{ $gedungSlug }}">
            <input type="hidden" name="lantai"      value="{{ $lantai }}">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Ruang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-door-open text-sm"></i>
                    </span>
                    <input type="text" id="editNamaRuang" name="nama_ruang" maxlength="25"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Ruang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-hashtag text-sm"></i>
                    </span>
                    <input type="text" id="editNomorRuang" name="nomor_ruang" maxlength="5"
                           style="text-transform:uppercase"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Ruang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-tags text-sm"></i>
                    </span>
                    <select id="editJenisRuang" name="id_jenis_ruang"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all appearance-none">
                        <option value="">-- Pilih Jenis Ruang --</option>
                        @foreach($jenisRuang as $jr)
                        <option value="{{ $jr->id }}">{{ $jr->nama_jenis_ruang ?? $jr->nama }}</option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditModal()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    <i class="fa-solid fa-xmark text-xs"></i> Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-all">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>



@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ── MODAL CREATE ─────────────────────────────────────────────
    function openModal() {
        document.getElementById('modalRuangan').classList.remove('hidden');
        setTimeout(() => document.getElementById('modalPanel').classList.remove('scale-95','opacity-0'), 10);
    }
    function closeModal() {
        document.getElementById('modalPanel').classList.add('scale-95','opacity-0');
        setTimeout(() => document.getElementById('modalRuangan').classList.add('hidden'), 250);
    }
    @if($errors->any()) openModal(); @endif

    document.getElementById('nomor_ruang')?.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // ── MODAL EDIT ───────────────────────────────────────────────
    function openEditModal(id, namaRuang, nomorRuang, jenisRuangId) {
        // Set action form ke route Laravel update dengan ID
        document.getElementById('formEditRuangan').action = `/kasubag/ruangan/${id}`;

        document.getElementById('editNamaRuang').value  = namaRuang;
        document.getElementById('editNomorRuang').value = nomorRuang;
        document.getElementById('editJenisRuang').value = jenisRuangId;
        document.getElementById('editRuanganSubtitle').textContent = namaRuang;

        document.getElementById('modalEditRuangan').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('modalEditPanel').classList.remove('scale-95','opacity-0');
            document.getElementById('editNamaRuang').focus();
        }, 10);
    }
    function closeEditModal() {
        document.getElementById('modalEditPanel').classList.add('scale-95','opacity-0');
        setTimeout(() => document.getElementById('modalEditRuangan').classList.add('hidden'), 250);
    }

    document.getElementById('editNomorRuang')?.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // ── MODAL DELETE ─────────────────────────────────────────────
    function confirmDelete(event, namaRuang) {
        event.preventDefault(); // Cegah submit form langsung

        const form = event.currentTarget
        Swal.fire({
            title: 'Hapus Ruangan?',
            html: `Kamu akan menghapus ruangan <strong>${namaRuang}</strong>. Jadwal yang menggunakan ruangan ini juga akan terpengaruh.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl  transition-all',
                cancelButton: 'bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-xl transition-all'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form jika user konfirmasi
            }
        });
    }

    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        closeModal(); closeEditModal(); closeDeleteModal();
    });

</script>
@endpush

</x-master>
