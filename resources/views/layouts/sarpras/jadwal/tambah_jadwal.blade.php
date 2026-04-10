<x-master>

<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-7">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Jadwal</h1>
        <p class="text-sm text-slate-500 mt-1">Tambahkan jadwal berdasarkan lokasi dan detail perkuliahan.</p>
    </div>

    <form action="{{ route('sarpras.simpan-jadwal') }}" method="POST" id="formJadwal">
        @csrf

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
                                @foreach($ruangan as $r)
                                    <option
                                        value="{{ $r->lantai }}"
                                        data-kampus="{{ $r->gedung->kampus->id ?? '' }}"
                                        data-gedung="{{ $r->gedung->slug ?? '' }}"
                                    >
                                        Lantai {{ $r->lantai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Ruangan</label>
                            <select name="ruangan_id" id="ruangan_id" required
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($ruangan as $r)
                                    <option
                                        value="{{ $r->id }}"
                                        data-kampus="{{ $r->gedung->kampus->id ?? '' }}"
                                        data-gedung="{{ $r->gedung->slug ?? '' }}"
                                        data-lantai="{{ $r->lantai }}"
                                        data-label="{{ $r->nomor_ruang }} - {{ $r->nama_ruang }}"
                                        data-gedung-nama="{{ $r->gedung->nama }}"
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
                            <input type="date" name="tanggal" required
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div></div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" required
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" required
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
                            <input type="text" name="mata_kuliah" required
                                placeholder="Contoh: Pemrograman Web"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Dosen Pengampu</label>
                            <input type="text" name="dosen_pengampu" required
                                placeholder="Contoh: Bapak/Ibu ..."
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Catatan</label>
                            <textarea name="catatan" rows="4"
                                placeholder="Contoh: Praktikum, butuh proyektor, dll"
                                class="w-full px-3 py-2.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition resize-none"></textarea>
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

                    <div class="px-5 pb-5 space-y-2">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-2.5 bg-primary text-white font-semibold text-sm rounded-xl hover:brightness-110 active:scale-95 transition-all">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            Simpan Jadwal
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
    const kampus  = document.getElementById('kampus_id');
    const gedung  = document.getElementById('gedung_slug');
    const lantai  = document.getElementById('lantai');
    const ruangan = document.getElementById('ruangan_id');

    const allGedung  = [...gedung.options];
    const allLantai  = [...lantai.options];
    const allRuangan = [...ruangan.options];

    function filterGedung() {
        gedung.innerHTML = '';
        allGedung.forEach(opt => {
            if (opt.value === '' || !kampus.value || opt.dataset.kampus == kampus.value) {
                gedung.appendChild(opt.cloneNode(true));
            }
        });
    }

    function filterLantai() {
        lantai.innerHTML = '';
        let used = new Set();
        allLantai.forEach(opt => {
            if (opt.value === '') { lantai.appendChild(opt.cloneNode(true)); return; }
            let match = (!kampus.value || opt.dataset.kampus == kampus.value) &&
                        (!gedung.value || opt.dataset.gedung == gedung.value);
            if (match && !used.has(opt.value)) {
                used.add(opt.value);
                lantai.appendChild(opt.cloneNode(true));
            }
        });
    }

    function filterRuangan() {
        ruangan.innerHTML = '';
        allRuangan.forEach(opt => {
            if (opt.value === '') { ruangan.appendChild(opt.cloneNode(true)); return; }
            let match = (!kampus.value || opt.dataset.kampus == kampus.value) &&
                        (!gedung.value  || opt.dataset.gedung  == gedung.value) &&
                        (!lantai.value  || opt.dataset.lantai  == lantai.value);
            if (match) ruangan.appendChild(opt.cloneNode(true));
        });
        updateSummary();
    }

    kampus.addEventListener('change', () => { filterGedung(); filterLantai(); filterRuangan(); });
    gedung.addEventListener('change', () => { filterLantai(); filterRuangan(); });
    lantai.addEventListener('change', filterRuangan);
    ruangan.addEventListener('change', updateSummary);

    document.querySelector('[name=tanggal]').addEventListener('change', updateSummary);
    document.querySelector('[name=waktu_mulai]').addEventListener('change', updateSummary);
    document.querySelector('[name=waktu_selesai]').addEventListener('change', updateSummary);

    filterGedung(); filterLantai(); filterRuangan();
});

function updateSummary() {
    const get    = id => document.getElementById(id);
    const selOpt = get('ruangan_id').selectedOptions[0];
    const tanggal   = document.querySelector('[name=tanggal]').value;
    const wMulai    = document.querySelector('[name=waktu_mulai]').value;
    const wSelesai  = document.querySelector('[name=waktu_selesai]').value;

    get('sumRuangan').textContent = selOpt?.value ? selOpt.dataset.label : '—';
    get('sumGedung').textContent  = selOpt?.value ? selOpt.dataset.gedungNama : '—';

    if (tanggal) {
        const fmt = d => new Date(d + 'T00:00:00').toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric'
        });
        get('sumTanggal').textContent = fmt(tanggal);
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
</script>

</x-master>
