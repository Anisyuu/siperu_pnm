<x-master>
    <div class="max-w-5xl mx-auto p-10 rounded-2xl bg-white border border-border-subtle shadow-sm">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-text-main">
                Form Peminjaman
            </h1>
            <p class="text-sm text-text-secondary mt-1">
                Isi form pengajuan peminjaman ruangan
            </p>
        </div>

        <form action="{{ route('ormawa.simpan-peminjaman') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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
                        <select id="kampus_id" class="form-control">
                            <option value="">-- Pilih Kampus --</option>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kampus }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Gedung --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Gedung</label>
                        <select id="gedung_slug" class="form-control">
                            <option value="">-- Pilih Gedung --</option>
                            @foreach($gedung as $g)
                                <option
                                    value="{{ $g->slug }}"
                                    data-kampus="{{ $g->kampus_id }}"
                                >
                                    {{ $g->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lantai --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Lantai</label>
                        <select id="lantai" class="form-control">
                            <option value="">-- Pilih Lantai --</option>
                            @foreach($ruangan->unique('lantai') as $r)
                                <option
                                    value="{{ $r->lantai }}"
                                    data-kampus="{{ $r->gedung->kampus->id }}"
                                    data-gedung="{{ $r->gedung->slug }}"
                                >
                                    Lantai {{ $r->lantai }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Ruangan --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Ruangan</label>
                        <select name="ruangan_id" id="ruangan_id" class="form-control">
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangan as $r)
                                <option
                                    value="{{ $r->id }}"
                                    data-kampus="{{ $r->gedung->kampus->id }}"
                                    data-gedung="{{ $r->gedung->slug }}"
                                    data-lantai="{{ $r->lantai }}"
                                >
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

            {{-- ===================== --}}
            {{-- SECTION DETAIL --}}
            {{-- ===================== --}}
            <div class="bg-gray-50 border border-border-subtle rounded-xl p-6">
                <h2 class="text-lg font-bold text-gray-500 mb-4">
                    Detail Peminjaman
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Tanggal --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">

                        @error('tanggal')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    {{-- Waktu Mulai --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" class="form-control">

                        @error('waktu_mulai')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Waktu Selesai --}}
                    <div>
                        <label class="text-sm font-semibold mb-2 block">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" class="form-control">

                        @error('waktu_selesai')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kegiatan --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold mb-2 block">Kegiatan</label>
                        <textarea name="kegiatan" rows="4" class="form-control">{{ old('kegiatan') }}</textarea>

                        @error('kegiatan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dokumen --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold mb-2 block">Dokumen Bukti</label>
                        <input type="file" name="dokumen_bukti" class="form-control">

                        @error('dokumen_bukti')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- BUTTON --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
                Nomor peminjaman akan dibuat otomatis setelah pengajuan dikirim.
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('ormawa.list-peminjaman') }}"
                   class="px-5 py-2 rounded-lg border border-border-subtle hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110 transition">
                    Kirim Pengajuan
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

    <script>
document.addEventListener("DOMContentLoaded", function () {

    const kampus = document.getElementById("kampus_id");
    const gedung = document.getElementById("gedung_slug");
    const lantai = document.getElementById("lantai");
    const ruangan = document.getElementById("ruangan_id");

    function reset(select) {
        select.value = "";
    }

    function filterOptions(select, callback) {
        Array.from(select.options).forEach(option => {
            if (option.value === "") {
                option.hidden = false;
                return;
            }

            option.hidden = !callback(option);
        });
    }

    // =========================
    // KAMPUS → GEDUNG
    // =========================
    kampus.addEventListener("change", function () {
        const kampusId = this.value;

        reset(gedung);
        reset(lantai);
        reset(ruangan);

        filterOptions(gedung, option => {
            return option.dataset.kampus === kampusId;
        });

        filterOptions(lantai, option => {
            return option.dataset.kampus === kampusId;
        });

        filterOptions(ruangan, option => {
            return option.dataset.kampus === kampusId;
        });
    });

    // =========================
    // GEDUNG → LANTAI
    // =========================
    gedung.addEventListener("change", function () {
        const kampusId = kampus.value;
        const gedungSlug = this.value;

        reset(lantai);
        reset(ruangan);

        filterOptions(lantai, option => {
            return option.dataset.kampus === kampusId &&
                   option.dataset.gedung === gedungSlug;
        });

        filterOptions(ruangan, option => {
            return option.dataset.kampus === kampusId &&
                   option.dataset.gedung === gedungSlug;
        });
    });

    // =========================
    // LANTAI → RUANGAN
    // =========================
    lantai.addEventListener("change", function () {
        const kampusId = kampus.value;
        const gedungSlug = gedung.value;
        const lantaiVal = this.value;

        reset(ruangan);

        filterOptions(ruangan, option => {
            return option.dataset.kampus === kampusId &&
                   option.dataset.gedung === gedungSlug &&
                   option.dataset.lantai === lantaiVal;
        });
    });

});
</script>

</x-master>
