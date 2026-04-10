<x-master>

<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-7">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Form Peminjaman Ruangan</h1>
        <p class="text-sm text-slate-500 mt-1">Isi form pengajuan dengan lengkap dan benar.</p>
    </div>

    <form action="{{ route('ormawa.simpan-peminjaman') }}" method="POST"
          enctype="multipart/form-data" id="formPeminjaman">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-5 items-start">

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
                                    <option value="{{ $k->id }}">{{ $k->nama_kampus }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Gedung</label>
                            <select id="gedung_slug"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Gedung --</option>
                                @foreach($gedung as $g)
                                    <option value="{{ $g->slug }}" data-kampus="{{ $g->kampus_id }}">
                                        {{ $g->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lantai</label>
                            <select id="lantai"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Lantai --</option>
                                @foreach($ruangan->unique('lantai')->sortBy('lantai') as $r)
                                    <option value="{{ $r->lantai }}"
                                        data-kampus="{{ $r->gedung->kampus->id }}"
                                        data-gedung="{{ $r->gedung->slug }}">
                                        Lantai {{ $r->lantai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Ruangan</label>
                            <select name="ruangan_id" id="ruangan_id" onchange="updateSummary()"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangan as $r)
                                    <option value="{{ $r->id }}"
                                        data-kampus="{{ $r->gedung->kampus->id }}"
                                        data-gedung="{{ $r->gedung->slug }}"
                                        data-lantai="{{ $r->lantai }}"
                                        data-label="{{ $r->nomor_ruang }} - {{ $r->nama_ruang }}"
                                        data-gedung-nama="{{ $r->gedung->nama }}"
                                        {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->nomor_ruang }} - {{ $r->nama_ruang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ruangan_id')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- SECTION 2: WAKTU --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">2</span>
                        Waktu Peminjaman
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}"
                                min="{{ date('Y-m-d') }}"
                                onchange="updateSummary()"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                            @error('tanggal_mulai')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}"
                                min="{{ date('Y-m-d') }}"
                                onchange="updateSummary()"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                            @error('tanggal_selesai')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai"
                                value="{{ old('waktu_mulai') }}"
                                onchange="updateSummary()"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                            @error('waktu_mulai')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai"
                                value="{{ old('waktu_selesai') }}"
                                onchange="updateSummary()"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                            @error('waktu_selesai')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- SECTION 3: KEGIATAN --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">3</span>
                        Detail Kegiatan
                    </p>

                    <div class="space-y-4">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama / Deskripsi Kegiatan</label>
                            <textarea name="kegiatan" rows="4"
                                placeholder="Contoh: Rapat koordinasi BEM semester genap 2026..."
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition resize-none">{{ old('kegiatan') }}</textarea>
                            @error('kegiatan')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                                Dokumen Pendukung
                                <span class="font-normal text-slate-400 ml-1">(opsional · PDF/JPG/PNG · maks 2MB)</span>
                            </label>
                            <label id="dropzone"
                                class="flex flex-col items-center justify-center gap-2 w-full border border-dashed border-slate-300 rounded-xl p-6 cursor-pointer hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up text-slate-300 text-2xl"></i>
                                <span class="text-sm text-slate-500" id="fileLabel">
                                    Seret file ke sini atau <span class="text-blue-500">klik untuk memilih</span>
                                </span>
                                <input type="file" name="dokumen_bukti" class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    onchange="showFileName(this)">
                            </label>
                            @error('dokumen_bukti')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- ===== KOLOM KANAN: RINGKASAN ===== --}}
            <div class="lg:sticky lg:top-6">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                    <div class="px-5 py-4 border-b border-slate-100">
                        <p class="text-sm font-bold text-slate-700">Ringkasan Pengajuan</p>
                    </div>

                    <div class="px-5 py-4 space-y-3 text-sm">
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-slate-400 flex-shrink-0">Ruangan</span>
                            <span class="font-semibold text-slate-700 text-right" id="sumRuangan">—</span>
                        </div>
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-slate-400 flex-shrink-0">Gedung</span>
                            <span class="text-slate-600 text-right" id="sumGedung">—</span>
                        </div>
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-slate-400 flex-shrink-0">Tanggal</span>
                            <span class="text-slate-600 text-right" id="sumTanggal">—</span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-slate-400 flex-shrink-0">Waktu</span>
                            <span class="text-slate-600" id="sumWaktu">—</span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-slate-400 flex-shrink-0">Durasi</span>
                            <span id="sumDurasi" class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">—</span>
                        </div>
                    </div>

                    <div class="px-5 pb-3">
                        <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2.5">
                            <i class="fa-solid fa-circle-info text-blue-400 text-xs mt-0.5 flex-shrink-0"></i>
                            <span class="text-xs text-blue-700">Nomor peminjaman dibuat otomatis setelah pengajuan terkirim.</span>
                        </div>
                    </div>

                    <div class="px-5 pb-5 space-y-2">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-2.5 bg-primary text-white font-semibold text-sm rounded-xl hover:brightness-110 active:scale-95 transition-all">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('ormawa.list-peminjaman') }}"
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

@push('js')
<script>
// ── Cascade filter lokasi ────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const sel     = id => document.getElementById(id);
    const kampus  = sel('kampus_id');
    const gedung  = sel('gedung_slug');
    const lantai  = sel('lantai');
    const ruangan = sel('ruangan_id');

    function filterOpts(select, test) {
        Array.from(select.options).forEach(o => {
            o.hidden = o.value !== '' && !test(o);
        });
        if (select.selectedOptions[0]?.hidden) select.value = '';
        updateSummary();
    }

    kampus.addEventListener('change', () => {
        const k = kampus.value;
        filterOpts(gedung,  o => o.dataset.kampus === k);
        filterOpts(lantai,  o => o.dataset.kampus === k);
        filterOpts(ruangan, o => o.dataset.kampus === k);
    });

    gedung.addEventListener('change', () => {
        const k = kampus.value, g = gedung.value;
        filterOpts(lantai,  o => o.dataset.kampus === k && o.dataset.gedung === g);
        filterOpts(ruangan, o => o.dataset.kampus === k && o.dataset.gedung === g);
    });

    lantai.addEventListener('change', () => {
        const k = kampus.value, g = gedung.value, l = lantai.value;
        filterOpts(ruangan, o =>
            o.dataset.kampus === k &&
            o.dataset.gedung === g &&
            o.dataset.lantai === l
        );
    });
});

// ── Ringkasan dinamis ────────────────────────────────────────────
function updateSummary() {
    const get      = id => document.getElementById(id);
    const selOpt   = get('ruangan_id').selectedOptions[0];
    const tMulai   = document.querySelector('[name=tanggal_mulai]').value;
    const tSelesai = document.querySelector('[name=tanggal_selesai]').value;
    const wMulai   = document.querySelector('[name=waktu_mulai]').value;
    const wSelesai = document.querySelector('[name=waktu_selesai]').value;

    get('sumRuangan').textContent = selOpt?.value ? selOpt.dataset.label : '—';
    get('sumGedung').textContent  = selOpt?.value
        ? `${selOpt.dataset.gedungNama} Lt.${selOpt.dataset.lantai}` : '—';

    if (tMulai) {
        const fmt = d => new Date(d + 'T00:00:00').toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric'
        });
        get('sumTanggal').textContent = (tSelesai && tMulai !== tSelesai)
            ? `${fmt(tMulai)} – ${fmt(tSelesai)}`
            : fmt(tMulai);
    } else {
        get('sumTanggal').textContent = '—';
    }

    if (wMulai && wSelesai) {
        get('sumWaktu').textContent = `${wMulai} – ${wSelesai}`;
        const [hM, mM] = wMulai.split(':').map(Number);
        const [hS, mS] = wSelesai.split(':').map(Number);
        const menit = (hS * 60 + mS) - (hM * 60 + mM);
        if (menit > 0) {
            const jam = Math.floor(menit / 60), sisa = menit % 60;
            get('sumDurasi').textContent = sisa ? `${jam}j ${sisa}m` : `${jam} jam`;
        } else {
            get('sumDurasi').textContent = '—';
        }
    } else {
        get('sumWaktu').textContent  = '—';
        get('sumDurasi').textContent = '—';
    }
}

// ── File upload label ────────────────────────────────────────────
function showFileName(input) {
    const label = document.getElementById('fileLabel');
    label.innerHTML = input.files[0]
        ? `<span class="font-semibold text-slate-700">${input.files[0].name}</span>`
        : `Seret file ke sini atau <span class="text-blue-500">klik untuk memilih</span>`;
}
</script>
@endpush

</x-master>