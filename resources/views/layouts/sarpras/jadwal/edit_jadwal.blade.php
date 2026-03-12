<x-master>
    @php
        $selectedKampusId = old('kampus_id', $jadwal->ruangan->gedung->kampus->id ?? '');
        $selectedGedungSlug = old('gedung_slug', $jadwal->ruangan->gedung->slug ?? '');
        $selectedJenisRuangId = old('jenis_ruang_id', $jadwal->ruangan->id_jenis_ruang ?? '');
        $selectedRuanganId = old('ruangan_id', $jadwal->ruangan_id);
    @endphp

    <div class="max-w-4xl mx-auto p-10 rounded-2xl bg-white/80 border-2 border-gray-200">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-text-main dark:text-white">
                Edit Jadwal
            </h1>
            <p class="text-sm text-text-secondary mt-1">
                Perbarui jadwal penggunaan ruangan berdasarkan kampus, gedung, jenis ruang, dan ruangan.
            </p>
        </div>

        <form action="{{ route('sarpras.update-jadwal', $jadwal->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kampus --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Kampus
                    </label>
                    <select id="kampus_id"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white">
                        <option value="">-- Pilih Kampus --</option>
                        @foreach($kampus as $k)
                            <option value="{{ $k->id }}" {{ $selectedKampusId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Gedung --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Gedung
                    </label>
                    <select id="gedung_slug"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white">
                        <option value="">-- Pilih Gedung --</option>
                        @foreach($gedung as $g)
                            <option
                                value="{{ $g->slug }}"
                                data-kampus="{{ $g->kampus_id }}"
                                {{ $selectedGedungSlug == $g->slug ? 'selected' : '' }}
                            >
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Ruang --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Jenis Ruang
                    </label>
                    <select id="jenis_ruang_id"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white">
                        <option value="">-- Pilih Jenis Ruang --</option>
                        @foreach($jenisRuang as $jr)
                            <option value="{{ $jr->id }}" {{ $selectedJenisRuangId == $jr->id ? 'selected' : '' }}>
                                {{ $jr->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Ruangan --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Ruangan
                    </label>
                    <select name="ruangan_id" id="ruangan_id"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white">
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

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Tanggal
                    </label>
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal', $jadwal->tanggal) }}"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                    >
                </div>

                <div></div>

                {{-- Waktu Mulai --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Waktu Mulai
                    </label>
                    <input
                        type="time"
                        name="waktu_mulai"
                        value="{{ old('waktu_mulai', \Illuminate\Support\Str::substr($jadwal->waktu_mulai, 0, 5)) }}"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                    >
                </div>

                {{-- Waktu Selesai --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Waktu Selesai
                    </label>
                    <input
                        type="time"
                        name="waktu_selesai"
                        value="{{ old('waktu_selesai', \Illuminate\Support\Str::substr($jadwal->waktu_selesai, 0, 5)) }}"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                    >
                </div>

                {{-- Mata Kuliah --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Mata Kuliah
                    </label>
                    <input
                        type="text"
                        name="mata_kuliah"
                        maxlength="100"
                        value="{{ old('mata_kuliah', $jadwal->mata_kuliah) }}"
                        placeholder="Contoh: Pemrograman Web"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                    >
                </div>

                {{-- Dosen Pengampu --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Dosen Pengampu
                    </label>
                    <input
                        type="text"
                        name="dosen_pengampu"
                        maxlength="100"
                        value="{{ old('dosen_pengampu', $jadwal->dosen_pengampu) }}"
                        placeholder="Contoh: Bapak/Ibu ..."
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                    >
                </div>

                {{-- Catatan --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-text-main dark:text-white">
                        Catatan
                    </label>
                    <textarea
                        name="catatan"
                        rows="4"
                        placeholder="Contoh: Praktikum, butuh proyektor, dll"
                        class="w-full px-4 py-2.5 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                    >{{ old('catatan', $jadwal->catatan) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('sarpras.kelola-jadwal') }}"
                   class="px-5 py-2.5 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-2.5 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
                    Update Jadwal
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kampusSelect = document.getElementById('kampus_id');
            const gedungSelect = document.getElementById('gedung_slug');
            const jenisSelect = document.getElementById('jenis_ruang_id');
            const ruanganSelect = document.getElementById('ruangan_id');

            const selectedGedung = @json($selectedGedungSlug);
            const selectedRuangan = @json((string) $selectedRuanganId);

            const allGedungOptions = Array.from(gedungSelect.options);
            const allRuanganOptions = Array.from(ruanganSelect.options);

            function filterGedung() {
                const kampusId = kampusSelect.value;
                const currentSelected = gedungSelect.value || selectedGedung;

                gedungSelect.innerHTML = '';

                allGedungOptions.forEach(option => {
                    if (option.value === '' || !kampusId || option.dataset.kampus === kampusId) {
                        const cloned = option.cloneNode(true);

                        if (cloned.value === currentSelected) {
                            cloned.selected = true;
                        }

                        gedungSelect.appendChild(cloned);
                    }
                });
            }

            function filterRuangan() {
                const kampusId = kampusSelect.value;
                const gedungSlug = gedungSelect.value;
                const jenisId = jenisSelect.value;
                const currentSelected = ruanganSelect.value || selectedRuangan;

                ruanganSelect.innerHTML = '';

                allRuanganOptions.forEach(option => {
                    if (option.value === '') {
                        ruanganSelect.appendChild(option.cloneNode(true));
                        return;
                    }

                    const matchKampus = !kampusId || option.dataset.kampus === kampusId;
                    const matchGedung = !gedungSlug || option.dataset.gedung === gedungSlug;
                    const matchJenis = !jenisId || option.dataset.jenis === jenisId;

                    if (matchKampus && matchGedung && matchJenis) {
                        const cloned = option.cloneNode(true);

                        if (cloned.value === currentSelected) {
                            cloned.selected = true;
                        }

                        ruanganSelect.appendChild(cloned);
                    }
                });
            }

            kampusSelect.addEventListener('change', function () {
                gedungSelect.value = '';
                filterGedung();
                filterRuangan();
            });

            gedungSelect.addEventListener('change', function () {
                filterRuangan();
            });

            jenisSelect.addEventListener('change', function () {
                filterRuangan();
            });

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
