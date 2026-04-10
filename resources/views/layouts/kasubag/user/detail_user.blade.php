<x-master>
<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-7 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Detail Pengguna
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Informasi lengkap pengguna di dalam sistem
            </p>
        </div>

        @php
            $badge = $user->is_active == 'active'
                ? 'bg-green-50 text-green-700 border border-green-100'
                : 'bg-red-50 text-red-600 border border-red-100';
            $dot = $user->is_active == 'active' ? 'bg-green-500' : 'bg-red-400';
            $label = $user->is_active == 'active' ? 'Aktif' : 'Tidak Aktif';
        @endphp

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full {{ $badge }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
            {{ $label }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-5 items-start">

        {{-- KOLOM KIRI --}}
        <div class="space-y-4">

            {{-- SEKSI 1: IDENTITAS --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">1</span>
                    Identitas Pengguna
                </p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-slate-700">{{ $user->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Nomor Induk</p>
                        <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">
                            {{ $user->nomor_induk }}
                        </span>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Email</p>
                        <p class="text-slate-600">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Nomor Telepon</p>
                        <p class="text-slate-600">{{ $user->no_telp ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- SEKSI 2: AKSES --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">2</span>
                    Hak Akses
                </p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 mb-1">Role</p>
                        <p class="font-semibold text-slate-700">{{ ucfirst($user->roles->first()->nama ?? '-') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Status</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full {{ $badge }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                            {{ $label }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- TUTUP KOLOM KIRI --}}

        {{-- SIDEBAR --}}
        <div class="lg:sticky lg:top-6">
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-sm font-bold text-slate-700">Ringkasan Pengguna</p>
                </div>

                <div class="px-5 py-4 space-y-3 text-sm">

                    <div class="flex justify-center mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center">
                            <i class="fa-solid fa-user text-blue-500 text-xl"></i>
                        </div>
                    </div>

                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Nama</span>
                        <span class="font-semibold text-slate-700 text-right">{{ $user->nama_lengkap }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Email</span>
                        <span class="text-slate-600 text-right text-xs">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Role</span>
                        <span class="text-slate-600 text-right">{{ ucfirst($user->roles->first()->nama ?? '-') }}</span>
                    </div>
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-slate-400 shrink-0">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full {{ $badge }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                            {{ $label }}
                        </span>
                    </div>
                </div>

                <div class="px-5 pb-3">
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2.5">
                        <i class="fa-solid fa-circle-info text-blue-400 text-xs mt-0.5 shrink-0"></i>
                        <span class="text-xs text-blue-700 font-mono">{{ $user->nomor_induk }}</span>
                    </div>
                </div>

                <div class="px-5 pb-5 flex flex-col gap-2">
                    <a href="{{ route('kasubag.edit-user', $user->nomor_induk) }}"
                       class="w-full flex items-center justify-center gap-2 py-2.5 bg-primary text-white font-semibold text-sm rounded-xl hover:brightness-110 transition">
                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                        Edit Pengguna
                    </a>
                    <a href="{{ route('kasubag.list-user') }}"
                       class="w-full flex items-center justify-center gap-2 py-2.5 border border-slate-200 text-slate-600 font-semibold text-sm rounded-xl hover:bg-slate-50 transition-colors">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
        {{-- TUTUP SIDEBAR --}}

    </div>
    {{-- TUTUP GRID --}}

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
