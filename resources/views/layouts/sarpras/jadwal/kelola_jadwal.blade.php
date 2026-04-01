<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">

    {{-- HEADER --}}
    <div class="flex items-start justify-between mb-8 flex-wrap gap-4">

        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Kelola Jadwal
            </h1>

            <p class="text-slate-500 mt-1 text-sm">
                Manajemen jadwal penggunaan ruangan
            </p>
        </div>

        <div class="flex items-center gap-3">

            {{-- Total Jadwal --}}
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">

                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-calendar text-blue-500 text-sm"></i>
                </div>

                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">
                        Total Jadwal
                    </div>
                    <div class="text-lg font-bold text-slate-800">
                        {{ $jadwal->total() }}
                    </div>
                </div>

            </div>

            {{-- Button tambah --}}
            <a href="{{ route('sarpras.tambah-jadwal') }}"
               class="px-5 py-5 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
                <i class="fa-solid fa-plus text-sm"></i>
            </a>

        </div>
    </div>


    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- FILTER --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">

            <form method="GET" action="{{ route('sarpras.kelola-jadwal') }}"
                  class="flex flex-col md:flex-row gap-3 w-full items-center">

                {{-- Search --}}
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari mata kuliah / dosen..."
                    class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
                />

                {{-- Ruangan --}}
                <select
                    name="ruangan_id"
                    class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800"
                >
                    <option value="">Semua Ruangan</option>
                    @foreach ($ruangan as $r)
                        <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruang }} - {{ $r->gedung->nama ?? '-' }}
                        </option>
                    @endforeach
                </select>

                {{-- Tanggal --}}
                <input
                    type="date"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                    class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800"
                />

                {{-- Button --}}
                <button type="submit"
                    class="px-5 py-2 bg-primary text-white rounded-lg hover:brightness-110 transition">
                    Filter
                </button>

                <a href="{{ route('sarpras.kelola-jadwal') }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg border border-border-subtle hover:bg-gray-50 transition">
                    Reset
                </a>

            </form>

        </div>


        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

    <thead class="bg-gray-50 border-b border-border-subtle text-text-main uppercase text-xs tracking-wider">
        <tr>
            <th class="px-6 py-4 text-left">No</th>
            <th class="px-6 py-4 text-left">Tanggal</th>
            <th class="px-6 py-4 text-left">Ruangan</th>
            <th class="px-6 py-4 text-left">Lokasi</th>
            <th class="px-6 py-4 text-left">Waktu</th>
            <th class="px-6 py-4 text-left">Perkuliahan</th>
            <th class="px-6 py-4 text-center">Action</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-border-subtle">

        @forelse ($jadwal as $j)
        <tr class="hover:bg-gray-50 transition">

            {{-- NO --}}
            <td class="px-6 py-4 text-text-secondary">
                {{ ($jadwal->currentPage() - 1) * $jadwal->perPage() + $loop->iteration }}
            </td>

            {{-- Tanggal --}}
            <td class="px-6 py-4">
                <div class="font-semibold text-text-main">
                    {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->translatedFormat('d F Y') }}
                </div>
                <div class="text-xs text-text-secondary">
                    {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->translatedFormat('l') }}
                </div>
            </td>

            {{-- Ruangan --}}
            <td class="px-6 py-4">
                <div class="font-semibold text-text-main">
                    {{ $j->ruangan->nama_ruang ?? '-' }}
                </div>
                <div class="text-xs text-text-secondary">
                    {{ $j->ruangan->nomor_ruang ?? '-' }}
                </div>
            </td>

            {{-- Lokasi --}}
            <td class="px-6 py-4 text-text-secondary">
                <div>{{ $j->ruangan->gedung->kampus->nama_kampus ?? '-' }}</div>
                <div class="text-xs">
                    {{ $j->ruangan->gedung->nama ?? '-' }}
                </div>
            </td>

            {{-- Waktu --}}
            <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full bg-primary/10 text-primary px-3 py-1 text-xs font-semibold">
                    {{ substr($j->waktu_mulai,0,5) }} - {{ substr($j->waktu_selesai,0,5) }}
                </span>
            </td>

            {{-- Perkuliahan --}}
            <td class="px-6 py-4">
                <div class="font-semibold text-text-main">
                    {{ $j->mata_kuliah }}
                </div>
                <div class="text-sm text-text-secondary">
                    {{ $j->dosen_pengampu }}
                </div>
            </td>

            {{-- Action --}}
            <td class="px-6 py-4">
                <div class="flex justify-center items-center gap-3">

                    {{-- Edit --}}
                    <a href="{{ route('sarpras.edit-jadwal', $j->id) }}"
                       class="w-8 h-8 flex items-center justify-center bg-orange-200/40 border border-orange-300 text-orange-500 rounded-lg hover:bg-orange-300/50 transition">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('sarpras.hapus-jadwal', $j->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="w-8 h-8 flex items-center justify-center bg-red-200/40 border border-red-300 text-red-500 rounded-lg hover:bg-red-300/50 transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>

                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                Data jadwal belum tersedia
            </td>
        </tr>
        @endforelse

    </tbody>

</table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $jadwal->links() }}
        </div>

    </div>
</div>

</x-master>
