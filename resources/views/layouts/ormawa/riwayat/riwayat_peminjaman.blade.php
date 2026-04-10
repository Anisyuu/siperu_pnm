<x-master>

    <div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                    Riwayat Peminjaman
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Riwayat seluruh pengajuan peminjaman ruangan
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-file-circle-check text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pengajuan</p>
                        <p class="text-xl font-extrabold text-slate-800">{{ $peminjaman->total() }}</p>
                    </div>
                </div>
                {{-- <a href="{{ route('ormawa.ajukan-peminjaman') }}"
                   class="inline-flex items-center justify-center w-11 h-11 bg-primary text-white rounded-2xl shadow-sm hover:brightness-110 transition">
                    <i class="fa-solid fa-plus text-sm"></i>
                </a> --}}
            </div>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('ormawa.list-peminjaman') }}" class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kegiatan..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    />
                </div>
                <select
                    name="status"
                    class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                >
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200">
                    Terapkan
                </button>
                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('ormawa.list-peminjaman') }}"
                    class="px-4 py-2.5 border border-slate-200 text-sm text-slate-500 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Reset
                </a>
                @endif
                <button type="button"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-file-export text-slate-400"></i>
                    Export
                </button>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No. Peminjaman</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Diajukan</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kegiatan</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ruangan</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Waktu</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($peminjaman as $item)
                            <tr class="hover:bg-slate-50/70 transition-colors group">

                                <td class="px-5 py-4">
                                    <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">
                                        {{ $item->no_peminjaman }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                </td>

                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-800 text-sm leading-tight">
                                        {{ $item->kegiatan }}
                                    </p>
                                </td>

                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-700 text-sm leading-tight">
                                        {{ $item->ruangan->nomor_ruang ?? '-' }} - {{ $item->ruangan->nama_ruang ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $item->ruangan->gedung->nama ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                    @if($item->tanggal_mulai !== $item->tanggal_selesai)
                                        <div class="text-xs text-slate-400">
                                            s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} –
                                    {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                                </td>

                                <td class="px-4 py-4">
                                    @php
                                        $badge = match($item->status) {
                                            'disetujui' => 'bg-green-50 text-green-700 border border-green-100',
                                            'ditolak'   => 'bg-red-50 text-red-600 border border-red-100',
                                            default     => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        };
                                        $dot = match($item->status) {
                                            'disetujui' => 'bg-green-500',
                                            'ditolak'   => 'bg-red-400',
                                            default     => 'bg-amber-500',
                                        };
                                        $label = match($item->status) {
                                            'disetujui' => 'Disetujui',
                                            'ditolak'   => 'Ditolak',
                                            default     => 'Menunggu',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full {{ $badge }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                                        {{ $label }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('ormawa.detail-peminjaman', $item->id) }}"
                                           class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-500 hover:bg-blue-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                            <i class="fa-regular fa-eye text-sm"></i>
                                        </a>

                                        @if ($item->status == 'pending')
                                            <form action="{{ route('ormawa.batalkan-peminjaman', $item->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-9 h-9 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-500 text-sm">Belum ada pengajuan peminjaman</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Coba ubah filter pencarian Anda.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($peminjaman->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/40">
                {{ $peminjaman->links() }}
            </div>
            @endif
        </div>

    </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
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
