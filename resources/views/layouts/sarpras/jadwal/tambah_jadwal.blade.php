<x-master>
    <div class="max-w-5xl mx-auto p-10 rounded-2xl bg-white border border-border-subtle shadow-sm">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-text-main">
                Tambah Jadwal
            </h1>
            <p class="text-sm text-text-secondary mt-1">
                Tambahkan jadwal berdasarkan lokasi dan detail perkuliahan
            </p>
        </div>

        <form action="{{ route('sarpras.simpan-jadwal') }}" method="POST" class="space-y-8">
            @csrf

            {{-- ===================== --}}
            {{-- SECTION LOKASI --}}
            {{-- ===================== --}}
            <div class="bg-gray-50 border border-border-subtle rounded-xl p-6">
                <h2 class="text-lg font-bold text-gray-500 mb-4">
                    Lokasi Ruangan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Kampus --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Kampus</label>
                        <select name="kampus_id" id="kampus_id" class="form-control">
                            <option value="">-- Pilih Kampus --</option>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kampus }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Gedung --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Gedung</label>
                        <select name="gedung_slug" id="gedung_slug" class="form-control">
                            <option value="">-- Pilih Gedung --</option>
                            @foreach($gedung as $g)
                                <option value="{{ $g->slug }}" data-kampus="{{ $g->kampus_id }}">
                                    {{ $g->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lantai --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Lantai</label>
                        <select name="lantai" id="lantai" class="form-control">
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

                    {{-- Ruangan (SEJAJAR DENGAN LANTAI) --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Ruangan</label>
                        <select name="ruangan_id" id="ruangan_id" class="form-control" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach ($ruangan as $r)
                            <option
                                value="{{ $r->id }}"
                                data-kampus="{{ $r->gedung->kampus->id ?? '' }}"
                                data-gedung="{{ $r->gedung->slug ?? '' }}"
                                data-lantai="{{ $r->lantai }}"
                            >
                                {{ $r->nomor_ruang }} - {{ $r->nama_ruang }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- ===================== --}}
            {{-- SECTION DETAIL --}}
            {{-- ===================== --}}
            <div class="bg-gray-50 border border-border-subtle rounded-xl p-6">
                <h2 class="text-lg font-bold text-gray-500 mb-4">
                    Detail Jadwal
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Tanggal --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div></div>

                    {{-- Waktu Mulai --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Waktu Mulai</label>
                        <input
                            type="time"
                            name="waktu_mulai"
                            class="form-control"
                            required
                        >
                    </div>

                    {{-- Waktu Selesai --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Waktu Selesai</label>
                        <input
                            type="time"
                            name="waktu_selesai"
                            class="form-control"
                            required
                        >
                    </div>

                    {{-- Mata Kuliah --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold mb-2 block">Mata Kuliah</label>
                        <input type="text" name="mata_kuliah" class="form-control" required>
                    </div>

                    {{-- Dosen --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold mb-2 block">Dosen Pengampu</label>
                        <input type="text" name="dosen_pengampu" class="form-control" required>
                    </div>

                    {{-- Catatan --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold mb-2 block">Catatan</label>
                        <textarea name="catatan" rows="4" class="form-control"></textarea>
                    </div>

                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('sarpras.kelola-jadwal') }}"
                   class="px-5 py-2 rounded-lg border border-border-subtle hover:bg-gray-50 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110 transition">
                    Simpan Jadwal
                </button>
            </div>

        </form>
    </div>

    {{-- STYLE --}}
    <style>
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: white;
            font-size: 14px;
        }
    </style>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const kampus = document.getElementById('kampus_id');
            const gedung = document.getElementById('gedung_slug');
            const lantai = document.getElementById('lantai');
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
                    if (opt.value === '') {
                        lantai.appendChild(opt.cloneNode(true));
                        return;
                    }

                    let match =
                        (!kampus.value || opt.dataset.kampus == kampus.value) &&
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
                    if (opt.value === '') {
                        ruangan.appendChild(opt.cloneNode(true));
                        return;
                    }

                    let match =
                        (!kampus.value || opt.dataset.kampus == kampus.value) &&
                        (!gedung.value || opt.dataset.gedung == gedung.value) &&
                        (!lantai.value || opt.dataset.lantai == lantai.value);

                    if (match) {
                        ruangan.appendChild(opt.cloneNode(true));
                    }
                });
            }

            kampus.addEventListener('change', () => {
                filterGedung();
                filterLantai();
                filterRuangan();
            });

            gedung.addEventListener('change', () => {
                filterLantai();
                filterRuangan();
            });

            lantai.addEventListener('change', filterRuangan);

            filterGedung();
            filterLantai();
            filterRuangan();
        });
    </script>

</x-master>
