<aside class="hidden md:flex w-80 flex-col dark:bg-[#111] min-h-screen transition-all">
    <div class="flex m-3 rounded-xl shadow-sm bg-white dark:bg-[#1d1d1d] h-full flex-col justify-between p-4 border border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-1">

            <div class="px-3 py-4 flex justify-center items-center gap-3 mb-2">
                <span class="text-gray-900 dark:text-white text-2xl font-black tracking-tight">
                    PinjamRuang<span class="text-primary text-blue-600">.</span>
                </span>
            </div>

            <nav class="flex flex-col gap-1">
                
                @php
                    // Helper styling untuk mengurangi repetisi kode
                    $activeClass = "bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400";
                    $inactiveClass = "text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 transition-all duration-200";
                    $iconActive = "text-blue-600 dark:text-blue-400";
                    $iconInactive = "text-gray-400 group-hover:text-gray-600";
                @endphp

                @hasRole('kasubag')
                    <a href="{{ route('kasubag.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-solid fa-border-all w-5 {{ request()->routeIs('kasubag.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('kasubag.jadwal-ruangan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('kasubag.jadwal-ruangan') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>

                    <a href="{{ route('kasubag.list-user') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.list-user') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-user w-5 {{ request()->routeIs('kasubag.list-user') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Kelola Pengguna</span>
                    </a>

                    <div class="flex flex-col">
                        @php $isRuanganActive = request()->routeIs('kasubag.jenis-ruang.*') || request()->routeIs('kasubag.kampus.*'); @endphp
                        <button id="kelolaRuanganBtn" type="button" class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isRuanganActive ? 'text-blue-600' : $inactiveClass }}">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-5"></i>
                                <span class="text-sm font-semibold">Ruangan</span>
                            </div>
                            <i id="kelolaRuanganIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isRuanganActive ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="kelolaRuanganSubmenu" class="{{ $isRuanganActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1">
                            <a href="{{ route('kasubag.jenis-ruang.index') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.jenis-ruang.*') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">Jenis Ruangan</a>
                            <a href="{{ route('kasubag.kampus.index') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.kampus.*') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">Kampus & Gedung</a>
                        </div>
                    </div>

                    <a href="{{ route('kasubag.verifikasi-peminjaman') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.verifikasi-peminjaman') ? $activeClass : $inactiveClass }}">
                        <i class="fa-solid fa-list-check w-5 {{ request()->routeIs('kasubag.verifikasi-peminjaman') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Verifikasi Peminjaman</span>
                    </a>

                    <div class="flex flex-col">
                        @php $isRiwayatActive = request()->routeIs('kasubag.riwayat-verifikasi') || request()->routeIs('kasubag.riwayat-peminjaman'); @endphp
                        <button id="RiwayatBtn" type="button" class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isRiwayatActive ? 'text-blue-600' : $inactiveClass }}">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clock-rotate-left w-5"></i>
                                <span class="text-sm font-semibold">Riwayat</span>
                            </div>
                            <i id="riwayatIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isRiwayatActive ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="riwayatSubmenu" class="{{ $isRiwayatActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1">
                            <a href="{{ route('kasubag.riwayat-verifikasi') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">Riwayat Verifikasi</a>
                            <a href="{{ route('kasubag.riwayat-peminjaman') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.riwayat-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">Riwayat Peminjaman</a>
                        </div>
                    </div>
                @endhasRole

                @hasRole('sarpras')
                    <a href="{{ route('sarpras.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('sarpras.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-solid fa-border-all w-5 {{ request()->routeIs('sarpras.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a href="{{ route('sarpras.kelola-jadwal') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('sarpras.kelola-jadwal') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('sarpras.kelola-jadwal') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>
                    <div class="flex flex-col">
                        @php $isPeminjamanSarprasActive = request()->routeIs('sarpras.verifikasi-peminjaman') || request()->routeIs('sarpras.riwayat-verifikasi'); @endphp
                        <button id="verfikasiPeminjamanBtn" type="button" class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isPeminjamanSarprasActive ? 'text-blue-600' : $inactiveClass }}">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-5"></i>
                                <span class="text-sm font-semibold">Peminjaman</span>
                            </div>
                            <i id="verfikasiPeminjamanIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isPeminjamanSarprasActive ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="verfikasiPeminjamanSubmenu" class="{{ $isPeminjamanSarprasActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 flex flex-col gap-1">
                            <a href="{{ route('sarpras.verifikasi-peminjaman') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('sarpras.verifikasi-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">Verifikasi</a>
                            <a href="{{ route('sarpras.riwayat-verifikasi') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('sarpras.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">Riwayat</a>
                        </div>
                    </div>
                @endhasRole

                @hasRole('pimpinan')
                    <a href="{{ route('pimpinan.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('pimpinan.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-house w-5 {{ request()->routeIs('pimpinan.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a href="{{ route('pimpinan.jadwal-ruangan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('pimpinan.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('pimpinan.jadwal-ruangan') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>
                    <div class="flex flex-col">
                        @php $isPimpinanActive = request()->routeIs('pimpinan.verifikasi-peminjaman') || request()->routeIs('pimpinan.riwayat-verifikasi'); @endphp
                        <button id="pimpinanVerifBtn" type="button" class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isPimpinanActive ? 'text-blue-600' : $inactiveClass }}">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-door-open w-5"></i>
                                <span class="text-sm font-semibold">Peminjaman</span>
                            </div>
                            <i id="pimpinanVerifIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isPimpinanActive ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="pimpinanVerifSubmenu" class="{{ $isPimpinanActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 flex flex-col gap-1">
                            <a href="{{ route('pimpinan.verifikasi-peminjaman') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('pimpinan.verifikasi-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">Verifikasi</a>
                            <a href="{{ route('pimpinan.riwayat-verifikasi') }}" class="pl-4 py-2 text-sm {{ request()->routeIs('pimpinan.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">Riwayat</a>
                        </div>
                    </div>
                @endhasRole

                @foreach(['ormawa', 'mahasiswa', 'dosen'] as $role)
                    @hasRole($role)
                        <a href="{{ route($role.'.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.dashboard') ? $activeClass : $inactiveClass }}">
                            <i class="fa-solid {{ $role == 'ormawa' ? 'fa-border-all' : 'fa-house' }} w-5"></i>
                            <span class="text-sm font-semibold">Dashboard</span>
                        </a>
                        <a href="{{ route($role.'.jadwal-ruangan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                            <i class="fa-regular fa-calendar w-5"></i>
                            <span class="text-sm font-semibold">Jadwal</span>
                        </a>
                        <a href="{{ route($role.'.ajukan-peminjaman') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.ajukan-peminjaman') ? $activeClass : $inactiveClass }}">
                            <i class="fa-regular fa-building w-5"></i>
                            <span class="text-sm font-semibold">Peminjaman</span>
                        </a>
                        <a href="{{ route($role.'.riwayat-peminjaman') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.riwayat-peminjaman') ? $activeClass : $inactiveClass }}">
                            <i class="fa-solid fa-clock-rotate-left w-5"></i>
                            <span class="text-sm font-semibold">Riwayat</span>
                        </a>
                    @endhasRole
                @endforeach

            </nav>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 font-bold text-sm">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>


@push("js")
<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleDropdown = (btnId, submenuId, iconId) => {
        const btn = document.getElementById(btnId);
        const submenu = document.getElementById(submenuId);
        const icon = document.getElementById(iconId);

        if (btn && submenu) {
            btn.addEventListener("click", function () {
                const isHidden = submenu.classList.toggle("hidden");
                if (icon) {
                    icon.classList.toggle("rotate-180", !isHidden);
                }
            });
        }
    };

    // Inisialisasi semua dropdown yang ada
    toggleDropdown("kelolaRuanganBtn", "kelolaRuanganSubmenu", "kelolaRuanganIcon");
    toggleDropdown("RiwayatBtn", "riwayatSubmenu", "riwayatIcon");
    toggleDropdown("verfikasiPeminjamanBtn", "verfikasiPeminjamanSubmenu", "verfikasiPeminjamanIcon");
    toggleDropdown("pimpinanVerifBtn", "pimpinanVerifSubmenu", "pimpinanVerifIcon");
});
</script>
@endpush    