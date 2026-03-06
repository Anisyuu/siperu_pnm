<x-master>

<div class="max-w-7xl mx-auto flex flex-col gap-8 p-10 rounded-2xl bg-white/80 border-2 border-gray-200">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Kelola Jadwal
            </h2>
            <p class="text-text-secondary text-sm mt-1">
                Manajemen jadwal penggunaan ruangan
            </p>
        </div>

        <a href="{{ route('sarpras.tambah-jadwal') }}"
           class="px-5 py-2 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
            + Tambah Jadwal
        </a>
    </div>

    <!-- ================= FILTER ================= -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">
        <div class="flex flex-col md:flex-row gap-3 items-center">
            <form method="GET" action="{{ route('sarpras.kelola-jadwal') }}"
                  class="flex flex-col md:flex-row gap-3 w-full">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari mata kuliah / dosen..."
                    class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
                />

                <select
                    name="ruangan_id"
                    class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                >
                    <option value="">Semua Ruangan</option>
                    @foreach ($ruangan as $r)
                        <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruang }}
                        </option>
                    @endforeach
                </select>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                    class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
                />

                <button type="submit"
                    class="h-10 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                    Terapkan
                </button>

                <a href="{{ route('sarpras.kelola-jadwal') }}"
                   class="h-10 px-6 flex items-center justify-center text-sm font-medium rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Reset
                </a>

            </form>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 text-text-main uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">Mata Kuliah</th>
                        <th class="px-6 py-4 text-left">Dosen</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-border-subtle dark:divide-gray-700">

                    @forelse ($jadwal as $j)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-6 py-4 text-text-secondary">
                                <div class="font-semibold text-text-main dark:text-white">
                                    {{ \Illuminate\Support\Carbon::parse($j->tanggal)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-text-secondary">
                                    {{ $j->hari ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                {{ $j->ruangan->nama_ruang ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                {{ substr($j->waktu_mulai, 0, 5) }} - {{ substr($j->waktu_selesai, 0, 5) }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-text-main dark:text-white">
                                    {{ $j->mata_kuliah }}
                                </div>
                                @if($j->catatan)
                                    <div class="text-xs text-text-secondary">
                                        {{ $j->catatan }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                {{ $j->dosen_pengampu }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-4 text-text-secondary">

                                    <a href="{{ route('sarpras.edit-jadwal', $j->id) }}" class="hover:text-yellow-500 transition">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('sarpras.hapus-jadwal', $j->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus jadwal ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-500 transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-text-secondary">
                                Data jadwal belum ada.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= PAGINATION ================= -->
    <div class="mt-6">
        {{ $jadwal->links() }}
    </div>

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
