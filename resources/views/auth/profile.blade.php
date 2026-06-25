<x-master>
    <div class="min-h-screen bg-slate-100 px-6 py-10">
        <div class="mx-auto max-w-5xl">

            {{-- HEADER --}}
            <div class="mb-7 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        Profile Pengguna
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-500">
                        Lihat ringkasan akun dan ubah password Anda.
                    </p>
                </div>

                @php
                    $initials = collect(explode(' ', $user->nama_lengkap))
                        ->filter()
                        ->take(2)
                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                        ->implode('');

                    $roleNames = $user->roles->pluck('nama')->implode(', ');
                @endphp

                <span class="px-4 py-2 text-sm font-semibold rounded-full
                    {{ $user->is_active === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $user->is_active === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_320px] items-start">

                {{-- KOLOM KIRI --}}
                <div class="space-y-4">

                    {{-- FORM GANTI PASSWORD --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">
                                1
                            </span>
                            Ganti Password
                        </p>

                        <p class="mb-5 text-sm text-slate-500">
                            Gunakan password baru yang aman dan tidak mudah ditebak.
                        </p>

                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if (session('success_password'))
                                <div class="mb-4 rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                                    <i class="fa-solid fa-circle-check mr-2"></i>
                                    {{ session('success_password') }}
                                </div>
                            @endif

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="mb-1 block text-sm text-slate-400">
                                        Password Lama
                                    </label>

                                    <div class="relative">
                                        <input
                                            type="password"
                                            name="password_lama"
                                            class="h-11 w-full rounded-xl border border-slate-200 bg-white px-4 pr-11 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                            placeholder="Masukkan password lama"
                                        >

                                        <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                        </div>
                                    </div>

                                    @error('password_lama')
                                        <p class="mt-1.5 text-xs font-semibold text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-1 block text-sm text-slate-400">
                                            Password Baru
                                        </label>

                                        <div class="relative">
                                            <input
                                                type="password"
                                                name="password"
                                                class="h-11 w-full rounded-xl border border-slate-200 bg-white px-4 pr-11 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                                placeholder="Minimal 8 karakter"
                                            >

                                            <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                                                <i class="fa-solid fa-key text-xs"></i>
                                            </div>
                                        </div>

                                        @error('password')
                                            <p class="mt-1.5 text-xs font-semibold text-red-500">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-sm text-slate-400">
                                            Konfirmasi Password Baru
                                        </label>

                                        <div class="relative">
                                            <input
                                                type="password"
                                                name="password_confirmation"
                                                class="h-11 w-full rounded-xl border border-slate-200 bg-white px-4 pr-11 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                                placeholder="Ulangi password baru"
                                            >

                                            <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                                                <i class="fa-solid fa-check-double text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 flex justify-end">
                                <button
                                    type="submit"
                                    class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200">
                                    <i class="fa-solid fa-shield-halved text-xs"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                {{-- TUTUP KOLOM KIRI --}}

                {{-- SIDEBAR PROFILE --}}
                <div class="lg:sticky lg:top-6">
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                        <div class="px-5 py-4 border-b border-slate-100">
                            <p class="text-sm font-bold text-slate-700">
                                Ringkasan Profile
                            </p>
                        </div>

                        <div class="px-5 py-5">
                            <div class="flex items-start gap-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-xl font-black text-blue-600">
                                    {{ $initials ?: 'U' }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h2 class="text-sm font-bold text-slate-800 leading-5">
                                        {{ $user->nama_lengkap }}
                                    </h2>

                                    <p class="mt-0.5 truncate text-xs text-slate-400">
                                        {{ $user->email }}
                                    </p>

                                    <span class="mt-2 inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-600 capitalize">
                                        {{ $roleNames ?: '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 py-4 space-y-3 text-sm border-t border-slate-100">
                            <div class="flex justify-between items-start gap-4">
                                <span class="text-slate-400 shrink-0">
                                    Nomor Induk
                                </span>

                                <span class="font-semibold text-slate-700 text-right">
                                    {{ $user->nomor_induk }}
                                </span>
                            </div>

                            <div class="flex justify-between items-start gap-4">
                                <span class="text-slate-400 shrink-0">
                                    No. Telepon
                                </span>

                                <span class="text-slate-600 text-right">
                                    {{ $user->no_telp ?: '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center gap-4">
                                <span class="text-slate-400 shrink-0">
                                    Role
                                </span>

                                <span class="text-slate-600 capitalize text-right">
                                    {{ $roleNames ?: '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center gap-4">
                                <span class="text-slate-400 shrink-0">
                                    Status
                                </span>

                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full
                                    {{ $user->is_active === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->is_active === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>

                        <div class="px-5 pb-5">
                            <div class="flex items-start gap-2 rounded-xl border border-blue-100 bg-blue-50 px-3 py-2.5">
                                <i class="fa-solid fa-circle-info text-blue-400 text-xs mt-0.5 shrink-0"></i>

                                <span class="text-xs text-blue-700">
                                    Data profile hanya dapat dilihat. Perubahan data akun dilakukan oleh pengelola sistem.
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- TUTUP SIDEBAR PROFILE --}}

            </div>

        </div>
    </div>
</x-master>
