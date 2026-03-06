<x-master>

<div class="max-w-3xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-text-main">
            Tambah Ruangan
        </h2>
        <p class="text-sm text-text-secondary mt-1">
            Tambahkan data ruangan baru
        </p>
    </div>

    <!-- FORM -->
    <form action="{{ route('kasubag.simpan-ruangan') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <!-- Jenis Ruangan -->
        <div>
            <label class="block text-sm font-semibold mb-2">
                Jenis Ruangan
            </label>

            <select name="id_jenis_ruang"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">

                <option value="">-- Pilih Jenis Ruangan --</option>

                @foreach($jenisRuang as $jenis)
                    <option value="{{ $jenis->id }}"
                        {{ old('id_jenis_ruang') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Gedung -->
        <div>
            <label class="block text-sm font-semibold mb-2">
                Gedung
            </label>

            <select name="id_gedung"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">

                <option value="">-- Pilih Gedung --</option>

                @foreach($gedung as $g)
                    <option value="{{ $g->id }}"
                        {{ old('id_gedung') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Lantai -->
        <div>
            <label class="block text-sm font-semibold mb-2">
                Lantai <small class="text-gray-500">(Angka)</small>
            </label>

            <input
                type="number"
                name="lantai"
                placeholder="Contoh: 1"
                value="{{ old('lantai') }}"
                min="1"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary"
            >
        </div>

        <!-- Nomor Ruang -->
        <div>
            <label class="block text-sm font-semibold mb-2">
                Nomor Ruang
            </label>

            <input
                type="text"
                name="nomor_ruang"
                maxlength="5"
                value="{{ old('nomor_ruang') }}"
                placeholder="Contoh: 101"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary"
            >
        </div>

        <!-- Nama Ruang -->
        <div>
            <label class="block text-sm font-semibold mb-2">
                Nama Ruang
            </label>

            <input
                type="text"
                name="nama_ruang"
                maxlength="25"
                value="{{ old('nama_ruang') }}"
                placeholder="Contoh: Lab Komputer"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary"
            >
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-3">

            <a href="{{ route('kasubag.kelola-ruangan') }}"
                class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110">
                Simpan Ruangan
            </button>

        </div>

    </form>

</div>

<!-- ERROR -->
@if ($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Oops...',
    html:`{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif

<!-- SUCCESS -->
@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:"{{ session('success') }}",
    timer:2000,
    showConfirmButton:false
});
</script>
@endif

</x-master>
