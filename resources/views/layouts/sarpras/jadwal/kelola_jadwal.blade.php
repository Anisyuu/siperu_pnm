<x-master>

<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                Kelola Jadwal
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Manajemen jadwal penggunaan ruangan
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-calendar text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Jadwal</p>
                    <p class="text-xl font-extrabold text-slate-800">{{ $jadwal->total() }}</p>
                </div>
            </div>
            <a href="{{ route('sarpras.tambah-jadwal') }}"
               class="inline-flex items-center justify-center w-11 h-11 bg-primary text-white rounded-2xl shadow-sm hover:brightness-110 transition">
                <i class="fa-solid fa-plus text-sm"></i>
            </a>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('sarpras.kelola-jadwal') }}"
          class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari mata kuliah / dosen..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                />
            </div>

            <select
                name="ruangan_id"
                class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
            >
                <option value="">Semua Ruangan</option>
                @foreach ($ruangan as $r)
                    <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>
                        {{ $r->nama_ruang }} - {{ $r->gedung->nama ?? '-' }}
                    </option>
                @endforeach
            </select>

            <input
                type="date"
                name="tanggal"
                value="{{ request('tanggal') }}"
                class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
            />

            <button type="submit"
                class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200">
                Terapkan
            </button>

            @if(request()->hasAny(['search', 'ruangan_id', 'tanggal']))
            <a href="{{ route('sarpras.kelola-jadwal') }}"
               class="px-4 py-2.5 border border-slate-200 text-sm text-slate-500 font-semibold rounded-xl hover:bg-slate-50 transition">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ruangan</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lokasi</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Waktu</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Perkuliahan</th>
                        <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse ($jadwal as $j)
                    <tr class="hover:bg-slate-50/70 transition-colors group">

                        <td class="px-5 py-4 text-sm text-slate-500">
                            {{ ($jadwal->currentPage() - 1) * $jadwal->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-4">
                            <p class="font-semibold text-slate-800 text-sm leading-tight">
                                {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->translatedFormat('d M Y') }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->translatedFormat('l') }}
                            </p>
                        </td>

                        <td class="px-4 py-4">
                            <p class="font-semibold text-slate-700 text-sm leading-tight">
                                {{ $j->ruangan->nama_ruang ?? '-' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $j->ruangan->nomor_ruang ?? '-' }}
                            </p>
                        </td>

                        <td class="px-4 py-4">
                            <p class="text-sm text-slate-600">{{ $j->ruangan->gedung->kampus->nama_kampus ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $j->ruangan->gedung->nama ?? '-' }}</p>
                        </td>

                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                {{ substr($j->waktu_mulai,0,5) }} – {{ substr($j->waktu_selesai,0,5) }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            <p class="font-semibold text-slate-800 text-sm leading-tight">{{ $j->mata_kuliah }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $j->dosen_pengampu }}</p>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('sarpras.edit-jadwal', $j->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-amber-50 text-amber-500 hover:bg-amber-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                                </a>
                                <form action="{{ route('sarpras.hapus-jadwal', $j->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-9 h-9 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                    <i class="fa-regular fa-calendar-xmark text-2xl text-slate-300"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-500 text-sm">Belum ada jadwal tersedia</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Coba ubah filter pencarian Anda.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jadwal->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/40">
            {{ $jadwal->links() }}
        </div>
        @endif
    </div>

</div>
</div>

</x-master>
