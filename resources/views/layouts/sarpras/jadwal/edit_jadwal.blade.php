<x-master>
    @php
        $selectedKampusId = old('kampus_id', $jadwal->ruangan->gedung->kampus->id ?? '');
        $selectedGedungSlug = old('gedung_slug', $jadwal->ruangan->gedung->slug ?? '');
        $selectedJenisRuangId = old('jenis_ruang_id', $jadwal->ruangan->id_jenis_ruang ?? '');
        $selectedRuanganId = old('ruangan_id', $jadwal->ruangan_id);
    @endphp

<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-7">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Jadwal</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui jadwal penggunaan ruangan berdasarkan lokasi dan detail perkuliahan.</p>
    </div>

    <form action="{{ route('sarpras.update-jadwal', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-5 items-start">

            {{-- ===== KOLOM KIRI ===== --}}
            <div class="space-y-4">

                {{-- SECTION 1: LOKASI --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">1</span>
                        Lokasi Ruangan
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kampus</label>
                            <select id="kampus_id"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Kampus --</option>
                                @foreach($kampus as $k)
                                    <option value="{{ $k->id }}" {{ $selectedKampusId == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kampus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Gedung</label>
                            <select id="gedung_slug"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Gedung --</option>
                                @foreach($gedung as $g)
                                    <option value="{{ $g->slug }}" data-kampus="{{ $g->kampus_id }}"
                                        {{ $selectedGedungSlug == $g->slug ? 'selected' : '' }}>
                                        {{ $g->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Jenis Ruang</label>
                            <select id="jenis_ruang_id"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Jenis Ruang --</option>
                                @foreach($jenisRuang as $jr)
                                    <option value="{{ $jr->id }}" {{ $selectedJenisRuangId == $jr->id ? 'selected' : '' }}>
                                        {{ $jr->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Ruangan</label>
                            <select name="ruangan_id" id="ruangan_id"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangan as $r)
                                    <option
                                        value="{{ $r->id }}"
                                        data-kampus="{{ $r->gedung->kampus->id ?? '' }}"
                                        data-gedung="{{ $r->gedung->slug ?? '' }}"
                                        data-jenis="{{ $r->id_jenis_ruang }}"
                                        {{ $selectedRuanganId == $r->id ? 'selected' : '' }}
                                    >
                                        {{ $r->nomor_ruang }} - {{ $r->nama_ruang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- SECTION 2: WAKTU --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">2</span>
                        Waktu Jadwal
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tanggal</label>
                            <input type="date" name="tanggal"
                                value="{{ old('tanggal', $jadwal->tanggal) }}"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div></div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai"
                                value="{{ old('waktu_mulai', \Illuminate\Support\Str::substr($jadwal->waktu_mulai, 0, 5)) }}"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai"
                                value="{{ old('waktu_selesai', \Illuminate\Support\Str::substr($jadwal->waktu_selesai, 0, 5)) }}"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                    </div>
                </div>

                {{-- SECTION 3: DETAIL PERKULIAHAN --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">3</span>
                        Detail Perkuliahan
                    </p>
                    <div class="space-y-4">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Mata Kuliah</label>
                            <input type="text" name="mata_kuliah" maxlength="100"
                                value="{{ old('mata_kuliah', $jadwal->mata_kuliah) }}"
                                placeholder="Contoh: Pemrograman Web"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Dosen Pengampu</label>
                            <input type="text" name="dosen_pengampu" maxlength="100"
                                value="{{ old('dosen_pengampu', $jadwal->dosen_pengampu) }}"
                                placeholder="Contoh: Bapak/Ibu ..."
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Catatan</label>
                            <textarea name="catatan" rows="4"
                                placeholder="Contoh: Praktikum, butuh proyektor, dll"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition resize-none"
                            >{{ old('catatan', $jadwal->catatan) }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            {{-- ===== KOLOM KANAN: RINGKASAN ===== --}}
            <div class="lg:sticky lg:top-6">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                    <div class="px-5 py-4 border-b border-slate-100">
                        <p class="text-sm font-bold text-slate-700">Ringkasan Jadwal</p>
                    </div>

                    <div class="px-5 py-4 space-y-3 text-sm">
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-slate-400 flex-shrink-0">Ruangan</span>
                            <span class="font-semibold text-slate-700 text-right">
                                {{ $jadwal->ruangan->nomor_ruang ?? '-' }} - {{ $jadwal->ruangan->nama_ruang ?? '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-slate-400 flex-shrink-0">Gedung</span>
                            <span class="text-slate-600 text-right">{{ $jadwal->ruangan->gedung->nama ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-slate-400 flex-shrink-0">Tanggal</span>
                            <span class="text-slate-600 text-right">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-slate-400 flex-shrink-0">Waktu</span>
                            <span class="text-slate-600">
                                {{ substr($jadwal->waktu_mulai, 0, 5) }} – {{ substr($jadwal->waktu_selesai, 0, 5) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-slate-400 flex-shrink-0">Mata Kuliah</span>
                            <span class="text-slate-600 text-right text-xs">{{ $jadwal->mata_kuliah }}</span>
                        </div>
                    </div>

                    <div class="px-5 pb-3">
                        <div class="flex items-start gap-2 bg-amber-50 border border-amber-100 rounded-xl px-3 py-2.5">
                            <i class="fa-solid fa-circle-info text-amber-400 text-xs mt-0.5 flex-shrink-0"></i>
                            <span class="text-xs text-amber-700">Perubahan akan langsung diterapkan setelah disimpan.</span>
                        </div>
                    </div>

                    <div class="px-5 pb-5 space-y-2">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-2.5 bg-primary text-white font-semibold text-sm rounded-xl hover:brightness-110 active:scale-95 transition-all">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            Update Jadwal
                        </button>
                        <a href="{{ route('sarpras.kelola-jadwal') }}"
                            class="w-full flex items-center justify-center gap-2 py-2.5 border border-slate-200 text-slate-600 font-semibold text-sm rounded-xl hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </form>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const kampusSelect   = document.getElementById('kampus_id');
    const gedungSelect   = document.getElementById('gedung_slug');
    const jenisSelect    = document.getElementById('jenis_ruang_id');
    const ruanganSelect  = document.getElementById('ruangan_id');

    const selectedGedung  = @json($selectedGedungSlug);
    const selectedRuangan = @json((string) $selectedRuanganId);

    const allGedungOptions  = Array.from(gedungSelect.options);
    const allRuanganOptions = Array.from(ruanganSelect.options);

    function filterGedung() {
        const kampusId = kampusSelect.value;
        const currentSelected = gedungSelect.value || selectedGedung;
        gedungSelect.innerHTML = '';
        allGedungOptions.forEach(option => {
            if (option.value === '' || !kampusId || option.dataset.kampus === kampusId) {
                const cloned = option.cloneNode(true);
                if (cloned.value === currentSelected) cloned.selected = true;
                gedungSelect.appendChild(cloned);
            }
        });
    }

    function filterRuangan() {
        const kampusId  = kampusSelect.value;
        const gedungSlug = gedungSelect.value;
        const jenisId   = jenisSelect.value;
        const currentSelected = ruanganSelect.value || selectedRuangan;
        ruanganSelect.innerHTML = '';
        allRuanganOptions.forEach(option => {
            if (option.value === '') { ruanganSelect.appendChild(option.cloneNode(true)); return; }
            const matchKampus = !kampusId   || option.dataset.kampus === kampusId;
            const matchGedung = !gedungSlug || option.dataset.gedung === gedungSlug;
            const matchJenis  = !jenisId    || option.dataset.jenis  === jenisId;
            if (matchKampus && matchGedung && matchJenis) {
                const cloned = option.cloneNode(true);
                if (cloned.value === currentSelected) cloned.selected = true;
                ruanganSelect.appendChild(cloned);
            }
        });
    }

    kampusSelect.addEventListener('change', function () { gedungSelect.value = ''; filterGedung(); filterRuangan(); });
    gedungSelect.addEventListener('change', filterRuangan);
    jenisSelect.addEventListener('change', filterRuangan);

    filterGedung();
    filterRuangan();
});
</script>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
@endif

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

</x-master>
