<x-master>

    <div class="bg-slate-100 min-h-screen px-6 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                    Kelola Pengguna
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Manajemen seluruh pengguna sistem
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-users text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                        <p class="text-xl font-extrabold text-slate-800">{{ $users->count() }}</p>
                    </div>
                </div>
                <a href="{{ route('kasubag.tambah-user') }}"
                   class="inline-flex items-center justify-center w-11 h-11 bg-primary text-white rounded-2xl shadow-sm hover:brightness-110 transition">
                    <i class="fa-solid fa-plus text-sm"></i>
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('kasubag.list-user') }}" class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    />
                </div>
                <select
                    name="status"
                    class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                >
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200">
                    Terapkan
                </button>
                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('kasubag.list-user') }}"
                    class="px-4 py-2.5 border border-slate-200 text-sm text-slate-500 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Reset
                </a>
                @endif
                <button type="button"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-file-export text-slate-400"></i>
                    Ekspor
                </button>
            </div>
        </form>

        {{-- TABEL --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pengguna</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nomor Induk</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50/70 transition-colors group">

                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-blue-500 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800 text-sm leading-tight">
                                                {{ $user->nama_lengkap }}
                                            </p>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                {{ $user->roles->first()->nama ?? 'Pengguna' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-4 py-4">
                                    <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">
                                        {{ $user->nomor_induk }}
                                    </span>
                                </td>

                                <td class="px-4 py-4">
                                    @if ($user->is_active == 'active')
                                        @php $badge = 'bg-green-50 text-green-700 border border-green-100'; $dot = 'bg-green-500'; $label = 'Aktif'; @endphp
                                    @else
                                        @php $badge = 'bg-red-50 text-red-600 border border-red-100'; $dot = 'bg-red-400'; $label = 'Tidak Aktif'; @endphp
                                    @endif
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full {{ $badge }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                                        {{ $label }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('kasubag.detail-user', $user->nomor_induk) }}"
                                           class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-500 hover:bg-blue-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                            <i class="fa-regular fa-eye text-sm"></i>
                                        </a>
                                        <form action="{{ route('kasubag.edit-user', $user->nomor_induk) }}" method="GET" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-9 h-9 bg-orange-50 text-orange-500 hover:bg-orange-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-500 text-sm">Belum ada pengguna</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Coba ubah filter pencarian Anda.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/40">
                {{ $users->links() }}
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
