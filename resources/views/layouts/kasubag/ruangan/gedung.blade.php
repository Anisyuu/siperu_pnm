<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">

    <x-breadcrumb :steps="[
        ['label' => 'Kampus', 'url' => route('kasubag.kampus.index'), 'subtitle' => $kampus->nama_kampus],
        ['label' => 'Gedung', 'active' => true],
    ]"/>

    <div class="flex items-start justify-between mb-8 flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Daftar Gedung</h1>
            <p class="mt-0.5 text-sm text-slate-500">
                Kelola gedung-gedung yang ada di <span class="font-semibold text-slate-700">{{ $kampus->nama_kampus }}</span>
            </p>
        </div>
        <button onclick="openModal()"
            class="inline-flex items-center gap-2 bg-primary hover:bg-blue-500 active:scale-95 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-all duration-200 cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Gedung
        </button>
    </div>

    {{-- BUILDING LIST — ACCORDION --}}
    <div class="flex flex-col gap-4">

        @forelse($gedung as $item)
        <div class="bg-white rounded-2xl overflow-hidden duration-200"
             id="gedung-card-{{ $item->slug }}">

            <div class="flex items-center gap-4 p-4 cursor-pointer select-none"
                 onclick="toggleFloor('{{ $item->slug }}', {{ $item->lantai }})">

                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100">
                    <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=200&q=70' }}"
                         alt="{{ $item->nama }}" class="w-full h-full object-cover">
                </div>

                <div class="flex-1 min-w-0 gap-1 flex flex-col">
                    <h2 class="text-base font-bold text-slate-900">{{ $item->nama }}</h2>
                    <div class="flex flex-wrap items-center">
                        <div class="flex items-center gap-1 bg-accent-light p-1.5 rounded-lg text-xs text-slate-600">
                            <i class="fa-solid fa-user-tie text-slate-600 text-[11px]"></i>
                            <span class="font-semibold">{{ $item->user->nama_lengkap ?? 'Belum ditentukan' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-solid fa-map-pin text-blue-400 text-[11px]"></i>
                            <span class="font-semibold">{{ $item->kampus->nama_kampus }}</span>
                        </div>
                        <span class="text-slate-200">|</span>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-solid fa-layer-group text-indigo-400 text-[11px]"></i>
                            <span class="font-semibold">{{ $item->lantai }} Lantai</span>
                        </div>
                        <span class="text-slate-200">|</span>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-solid fa-door-open text-emerald-400 text-[11px]"></i>
                            <span class="font-semibold">{{ $item->ruangan_count }} Ruangan</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    {{-- UBAH: tambah parameter fotoUrl --}}
                    <button type="button"
                            onclick="event.stopPropagation(); openEditGedung(
                                '{{ $item->slug }}',
                                '{{ addslashes($item->nama) }}',
                                {{ $item->lantai }},
                                '{{ $item->id_user }}',
                                '{{ $item->foto ? asset('storage/' . $item->foto) : '' }}'
                            )"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                            title="Edit">
                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                    </button>

                    <form action="{{ route('kasubag.gedung.destroy', $item->slug) }}" method="POST"
                          onsubmit="return confirmDeleteGedung(event, '{{ $item->nama }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="event.stopPropagation()"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all"
                                title="Hapus">
                            <i class="fa-regular fa-trash-can text-sm"></i>
                        </button>
                    </form>

                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 transition-all duration-200"
                         id="arrow-{{ $item->slug }}">
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"
                           id="arrow-icon-{{ $item->slug }}"></i>
                    </div>
                </div>
            </div>

            {{-- Floor panel inline --}}
            <div class="hidden border-t border-slate-100 bg-slate-50/60 px-5 py-4"
                 id="floor-panel-{{ $item->slug }}">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">
                    <i class="fa-solid fa-layer-group text-indigo-400 mr-1.5"></i>
                    Pilih Lantai untuk Melihat Ruangan
                </p>
                <div class="flex flex-wrap gap-3" id="floor-grid-{{ $item->slug }}">
                    <div class="text-xs text-slate-400 italic py-2">Memuat lantai...</div>
                </div>
            </div>
        </div>

        @empty
        <div class="flex flex-col items-center justify-center py-24 text-center bg-white rounded-2xl">
            <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mb-5">
                <i class="fa-solid fa-building text-4xl text-slate-300"></i>
            </div>
            <p class="text-slate-700 font-semibold text-lg">Belum ada gedung</p>
            <p class="text-slate-400 text-sm mt-1 max-w-xs">
                Tambahkan gedung pertama dengan klik <span class="font-semibold text-blue-500">+ Tambah Gedung</span>.
            </p>
        </div>
        @endforelse

    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL CREATE                                                  --}}
{{-- ============================================================ --}}
<div id="modalGedung" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal()"></div>
    <div id="modalPanel" class="relative bg-white rounded-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0">

        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-building-circle-arrow-right text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tambah Gedung Baru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">di <span class="font-semibold text-slate-600">{{ $kampus->nama_kampus }}</span></p>
                </div>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- UBAH: tambah enctype --}}
        <form action="{{ route('kasubag.gedung.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf
            <input type="hidden" name="kampus_id" value="{{ $kampus->id }}">

            {{-- Kampus (readonly) --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kampus</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-map-pin text-sm"></i>
                    </span>
                    <input type="text" value="{{ $kampus->nama_kampus }}" readonly
                           class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-500 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed">
                </div>
            </div>

            {{-- Nama Gedung --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Gedung <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-building text-sm"></i>
                    </span>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Gedung A" maxlength="25"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-slate-300 transition-all">
                </div>
                @error('nama')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Manager --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Manager / PIC Sarpras</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-user-tie text-sm"></i>
                    </span>
                    <select name="id_user" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all appearance-none">
                        <option value="">-- Pilih Manager --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->nomor_induk }}" {{ old('id_user') == $u->nomor_induk ? 'selected' : '' }}>
                            {{ $u->nama_lengkap }}
                        </option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </div>
            </div>

            {{-- Jumlah Lantai --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jumlah Lantai <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </span>
                    <input type="number" name="lantai" min="1" value="{{ old('lantai') }}" placeholder="Contoh: 5"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border {{ $errors->has('lantai') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-slate-300 transition-all">
                </div>
                <p class="mt-1 text-xs text-slate-400">Jumlah lantai menentukan pilihan lantai saat tambah ruangan.</p>
                @error('lantai')
                    <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- TAMBAH: Input Foto --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Foto Gedung
                    <span class="text-slate-400 text-xs font-normal">(opsional)</span>
                </label>

                {{-- Preview --}}
                <div id="previewCreate" class="hidden mb-2 rounded-xl overflow-hidden h-36 bg-slate-100">
                    <img id="previewImgCreate" src="" class="w-full h-full object-cover">
                </div>

                <label class="flex items-center gap-3 border-2 border-dashed border-slate-200
                               hover:border-indigo-400 rounded-xl p-4 cursor-pointer transition-all group">
                    <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center
                                text-indigo-400 group-hover:bg-indigo-100 shrink-0">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Klik untuk upload foto</p>
                        <p class="text-xs text-slate-400">JPG, PNG, WEBP — maks. 2MB</p>
                    </div>
                    <input type="file" name="foto" accept="image/*" class="hidden"
                           onchange="previewFoto(this, 'previewCreate', 'previewImgCreate')">
                </label>

                @error('foto')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    <i class="fa-solid fa-xmark text-xs"></i> Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Gedung
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL EDIT                                                    --}}
{{-- ============================================================ --}}
<div id="modalEditGedung" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEditGedung()"></div>
    <div id="modalEditGedungPanel" class="relative bg-white rounded-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0">

        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Edit Gedung</h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="editGedungSubtitle">Perbarui data gedung</p>
                </div>
            </div>
            <button onclick="closeEditGedung()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- UBAH: tambah enctype --}}
        <form id="formEditGedung" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="kampus_id" value="{{ $kampus->id }}">

            {{-- Nama Gedung --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Gedung <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-building text-sm"></i>
                    </span>
                    <input type="text" id="editGedungNama" name="nama" placeholder="Contoh: Gedung A" maxlength="25"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent placeholder:text-slate-300 transition-all">
                </div>
                <p id="editGedungErrNama" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                    <i class="fa-solid fa-circle-exclamation"></i><span></span>
                </p>
            </div>

            {{-- Manager --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Manager / PIC</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-user-tie text-sm"></i>
                    </span>
                    <select id="editGedungUser" name="id_user"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all appearance-none">
                        <option value="">-- Pilih Manager --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->nomor_induk }}">{{ $u->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </div>
            </div>

            {{-- Jumlah Lantai --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jumlah Lantai <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </span>
                    <input type="number" id="editGedungLantai" name="lantai" min="1"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
                </div>
            </div>

            {{-- TAMBAH: Input Foto Edit --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Foto Gedung
                    <span class="text-slate-400 text-xs font-normal">(kosongkan jika tidak diubah)</span>
                </label>

                {{-- Preview foto existing atau baru --}}
                <div id="previewEdit" class="hidden mb-2 rounded-xl overflow-hidden h-36 bg-slate-100">
                    <img id="previewImgEdit" src="" class="w-full h-full object-cover">
                </div>

                <label class="flex items-center gap-3 border-2 border-dashed border-slate-200
                               hover:border-amber-400 rounded-xl p-4 cursor-pointer transition-all group">
                    <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center
                                text-amber-400 group-hover:bg-amber-100 shrink-0">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Klik untuk ganti foto</p>
                        <p class="text-xs text-slate-400">JPG, PNG, WEBP — maks. 2MB</p>
                    </div>
                    <input type="file" name="foto" accept="image/*" class="hidden"
                           onchange="previewFoto(this, 'previewEdit', 'previewImgEdit')">
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditGedung()"
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
        document.getElementById('modalGedung').classList.remove('hidden');
        setTimeout(() => document.getElementById('modalPanel').classList.remove('scale-95', 'opacity-0'), 10);
    }
    function closeModal() {
        document.getElementById('modalPanel').classList.add('scale-95', 'opacity-0');
        setTimeout(() => document.getElementById('modalGedung').classList.add('hidden'), 300);
    }
    @if($errors->any()) openModal(); @endif

    // ── FLOOR ACCORDION ──────────────────────────────────────────
    const openFloors = new Set();

    function toggleFloor(slug, totalLantai) {
        const panel = document.getElementById(`floor-panel-${slug}`);
        const icon  = document.getElementById(`arrow-icon-${slug}`);
        const box   = document.getElementById(`arrow-${slug}`);
        const grid  = document.getElementById(`floor-grid-${slug}`);

        if (openFloors.has(slug)) {
            panel.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
            box.className = box.className.replace('bg-blue-100 text-pr','bg-slate-100 text-slate-400');
            openFloors.delete(slug);
            return;
        }

        openFloors.forEach(s => {
            document.getElementById(`floor-panel-${s}`)?.classList.add('hidden');
            const i = document.getElementById(`arrow-icon-${s}`);
            const b = document.getElementById(`arrow-${s}`);
            if (i) i.style.transform = 'rotate(0deg)';
            if (b) b.className = b.className.replace('bg-blue-100 text-pr','bg-slate-100 text-slate-400');
        });
        openFloors.clear();

        panel.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        box.className = box.className.replace('bg-slate-100 text-slate-400','bg-blue-100 text-pr');
        openFloors.add(slug);

        if (grid.dataset.loaded !== 'true') {
            grid.innerHTML = '';
            for (let i = 1; i <= totalLantai; i++) {
                const a = document.createElement('a');
                a.href = `/kasubag/ruangan/gedung/${slug}/lantai/${i}`;
                a.className = 'flex flex-col items-center justify-center gap-1.5 w-20 py-3 px-2 rounded-xl border-2 border-slate-200 bg-white hover:border-blue-500 hover:bg-blue-50 hover:-translate-y-0.5 transition-all duration-200';
                a.innerHTML = `
                    <i class="fa-solid fa-layer-group text-slate-400 text-base"></i>
                    <span class="text-sm font-bold text-slate-700 leading-none">${i}</span>
                    <span class="text-[10px] text-slate-400 font-semibold">Lantai</span>
                `;
                grid.appendChild(a);
            }
            grid.dataset.loaded = 'true';
        }
    }

    // ── PREVIEW FOTO ─────────────────────────────────────────────
    function previewFoto(input, previewWrapId, previewImgId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById(previewWrapId).classList.remove('hidden');
            document.getElementById(previewImgId).src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // ── MODAL EDIT ───────────────────────────────────────────────
    // UBAH: tambah parameter fotoUrl
    function openEditGedung(slug, nama, lantai, userId, fotoUrl = null) {
        document.getElementById('formEditGedung').action = `/kasubag/gedung/${slug}`;

        document.getElementById('editGedungNama').value   = nama;
        document.getElementById('editGedungLantai').value = lantai;
        document.getElementById('editGedungUser').value   = userId;
        document.getElementById('editGedungSubtitle').textContent = nama;

        // Tampilkan foto existing jika ada
        const previewEdit    = document.getElementById('previewEdit');
        const previewImgEdit = document.getElementById('previewImgEdit');
        if (fotoUrl && fotoUrl !== '') {
            previewEdit.classList.remove('hidden');
            previewImgEdit.src = fotoUrl;
        } else {
            previewEdit.classList.add('hidden');
            previewImgEdit.src = '';
        }

        const errEl = document.getElementById('editGedungErrNama');
        errEl.classList.add('hidden'); errEl.classList.remove('flex');

        document.getElementById('modalEditGedung').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('modalEditGedungPanel').classList.remove('scale-95', 'opacity-0');
            document.getElementById('editGedungNama').focus();
        }, 10);
    }

    function closeEditGedung() {
        document.getElementById('modalEditGedungPanel').classList.add('scale-95', 'opacity-0');
        setTimeout(() => document.getElementById('modalEditGedung').classList.add('hidden'), 300);
    }

    // ── KONFIRMASI HAPUS ─────────────────────────────────────────
    function confirmDeleteGedung(event, nama) {
        event.preventDefault();
        event.stopPropagation();

        const form = event.currentTarget;
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Gedung "${nama}" akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

        return false;
    }

    // ── ESCAPE KEY ───────────────────────────────────────────────
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        closeModal();
        closeEditGedung();
    });
</script>
@endpush

</x-master>
