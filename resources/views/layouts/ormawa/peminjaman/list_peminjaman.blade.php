<x-master>

    <div class="bg-slate-100 min-h-screen px-8 py-10">

        <div class="flex items-start justify-between mb-8 flex-wrap gap-4">

            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    List Pengajuan Peminjaman
                </h1>

                <p class="text-slate-500 mt-1 text-sm">
                    Manajemen seluruh pengajuan peminjaman ruangan
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">

                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-file-circle-check text-blue-500 text-sm"></i>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Total Pengajuan</div>
                        <div class="text-lg font-bold text-slate-800">
                            {{ $peminjaman->total() }}
                        </div>
                    </div>

                </div>

                <a href="{{ route('ormawa.ajukan-peminjaman') }}"
                   class="px-5 py-5 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
                    <i class="fa-solid fa-plus text-sm"></i>
                </a>

            </div>
        </div>

        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            <div class="bg-white rounded-xl border border-border-subtle p-4 shadow-sm">
                <div class="flex flex-col md:flex-row gap-3 items-center">

                    <form method="GET" action="{{ route('ormawa.list-peminjaman') }}" class="flex flex-col md:flex-row gap-3 w-full">

                        <input
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kegiatan..."
                            class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle bg-white focus:ring-2 focus:ring-primary focus:outline-none"
                        />

                        <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg hover:brightness-110 transition">
                            Cari
                        </button>

                        <select
                            name="status"
                            class="px-4 py-2 text-sm rounded-lg border border-border-subtle bg-white focus:ring-2 focus:ring-primary focus:outline-none"
                        >
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>

                        <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg hover:brightness-110 transition">
                            Filter
                        </button>
                    </form>

                    <button class="px-4 py-2 text-sm font-medium rounded-lg border border-border-subtle hover:bg-gray-50 transition">
                        Export
                    </button>

                </div>
            </div>

            <div class="bg-white rounded-xl border border-border-subtle shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-border-subtle text-text-main uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">No</th>
                                <th class="px-6 py-4 text-left">Diajukan</th>
                                <th class="px-6 py-4 text-left">Kegiatan</th>
                                <th class="px-6 py-4 text-left">Ruangan</th>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Waktu</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-border-subtle">
                            @forelse ($peminjaman as $item)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 text-text-secondary">
                                        {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 text-text-secondary">
                                        {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-text-main">
                                                {{ $item->kegiatan }}
                                            </p>
                                            <p class="text-xs text-text-secondary">
                                                {{ $item->no_peminjaman }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-text-secondary">
                                        {{ $item->ruangan->nama_ruang ?? '-' }}
                                        <div class="text-xs text-slate-400">
                                            {{ $item->ruangan->gedung->nama ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-text-secondary">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-text-secondary">
                                        {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($item->status == 'pending')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600">
                                                Pending
                                            </span>
                                        @elseif ($item->status == 'disetujui')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center gap-4 text-text-secondary">

                                            <a href="{{ route('ormawa.detail-peminjaman', $item->id) }}"
                                               class="w-8 h-8 flex items-center justify-center bg-blue-200/40 border border-blue-300 text-blue-500 rounded-lg hover:bg-blue-300/50 hover:border-blue-400 transition-all">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            @if ($item->status == 'pending')
                                                <form action="{{ route('ormawa.batalkan-peminjaman', $item->id) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-8 h-8 flex items-center justify-center bg-red-200/40 border border-red-300 text-red-500 rounded-lg hover:bg-red-300/50 hover:border-red-400 transition-all">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                                        Belum ada pengajuan peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $peminjaman->links() }}
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
