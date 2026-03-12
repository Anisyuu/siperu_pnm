<x-master>
    <div class="bg-slate-100 min-h-screen px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                        Kelola Jadwal
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Manajemen jadwal penggunaan ruangan berdasarkan kampus, gedung, dan lantai.
                    </p>
                </div>

                <a href="{{ route('sarpras.tambah-jadwal') }}"
                   class="inline-flex items-center justify-center px-5 py-3 bg-primary text-white rounded-2xl shadow-sm hover:brightness-110 transition">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Tambah Jadwal
                </a>
            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <form method="GET" action="{{ route('sarpras.kelola-jadwal') }}"
                      class="grid grid-cols-1 md:grid-cols-12 gap-3">

                    <div class="md:col-span-5">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari mata kuliah / dosen..."
                            class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800"
                        />
                    </div>

                    <div class="md:col-span-3">
                        <select
                            name="ruangan_id"
                            class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800"
                        >
                            <option value="">Semua Ruangan</option>
                            @foreach ($ruangan as $r)
                                <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama_ruang }}
                                    @if($r->gedung)
                                        - {{ $r->gedung->nama }}
                                    @endif
                                    (Lt. {{ $r->lantai }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800"
                        />
                    </div>

                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                            Terapkan
                        </button>

                        <a href="{{ route('sarpras.kelola-jadwal') }}"
                           class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-center text-slate-700">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 uppercase text-xs tracking-wider border-b border-slate-200 text-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Ruangan</th>
                                <th class="px-6 py-4 text-left">Lokasi</th>
                                <th class="px-6 py-4 text-left">Waktu</th>
                                <th class="px-6 py-4 text-left">Perkuliahan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse ($jadwal as $j)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 align-top">
                                        <div class="font-semibold text-slate-800">
                                            {{ \Illuminate\Support\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            {{ \Illuminate\Support\Carbon::parse($j->tanggal)->translatedFormat('l') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-top">
                                        <div class="font-semibold text-slate-800">
                                            {{ $j->ruangan->nama_ruang ?? '-' }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            {{ $j->ruangan->nomor_ruang ?? '-' }}
                                            @if(optional($j->ruangan->jenisRuangan)->nama)
                                                • {{ $j->ruangan->jenisRuangan->nama }}
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-top text-slate-600">
                                        <div>{{ $j->ruangan->gedung->kampus->nama_kampus ?? '-' }}</div>
                                        <div class="text-xs mt-1">
                                            {{ $j->ruangan->gedung->nama ?? '-' }}
                                            @if($j->ruangan)
                                                • Lt. {{ $j->ruangan->lantai }}
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-top text-slate-600">
                                        <span class="inline-flex items-center rounded-full bg-primary/10 text-primary px-3 py-1 text-xs font-semibold">
                                            {{ \Illuminate\Support\Str::substr($j->waktu_mulai, 0, 5) }}
                                            -
                                            {{ \Illuminate\Support\Str::substr($j->waktu_selesai, 0, 5) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 align-top">
                                        <div class="font-semibold text-slate-800">
                                            {{ $j->mata_kuliah }}
                                        </div>
                                        <div class="text-sm text-slate-500 mt-1">
                                            {{ $j->dosen_pengampu }}
                                        </div>
                                        @if($j->catatan)
                                            <div class="text-xs text-slate-500 mt-1">
                                                Catatan: {{ $j->catatan }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 align-top">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('sarpras.edit-jadwal', $j->id) }}"
                                               class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-yellow-50 hover:text-yellow-600 transition"
                                               title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('sarpras.hapus-jadwal', $j->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-9 h-9 inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-red-50 hover:text-red-600 transition"
                                                    title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                        Data jadwal belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $jadwal->links() }}
            </div>
        </div>
    </div>

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
