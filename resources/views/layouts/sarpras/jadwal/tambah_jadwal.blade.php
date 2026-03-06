<x-master>

<div class="max-w-3xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm">

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-text-main">
            Tambah Jadwal
        </h2>
        <p class="text-sm text-text-secondary mt-1">
            Tambahkan jadwal baru untuk ruangan
        </p>
    </div>

    <form action="{{ route('sarpras.simpan-jadwal') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold mb-2">Ruangan</label>
            <select name="ruangan_id"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangan as $r)
                    <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                        {{ $r->nama_ruang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Tanggal</label>
            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Mata Kuliah</label>
            <input type="text" name="mata_kuliah" maxlength="100" value="{{ old('mata_kuliah') }}"
                placeholder="Contoh: Pemrograman Web"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Dosen Pengampu</label>
            <input type="text" name="dosen_pengampu" maxlength="100" value="{{ old('dosen_pengampu') }}"
                placeholder="Contoh: Bapak/Ibu ..."
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Catatan (opsional)</label>
            <textarea name="catatan" rows="3"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary"
                placeholder="Contoh: Praktikum, butuh proyektor, dll">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('sarpras.kelola-jadwal') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110">
                Simpan Jadwal
            </button>
        </div>

    </form>

</div>

@if ($errors->any())
<script>
Swal.fire({ icon:'error', title:'Oops...', html:`{!! implode('<br>', $errors->all()) !!}` });
</script>
@endif

@if(session('success'))
<script>
Swal.fire({ icon:'success', title:'Berhasil', text:"{{ session('success') }}", timer:2000, showConfirmButton:false });
</script>
@endif

</x-master>
