<aside
    class="hidden md:flex w-64 flex-col dark:bg-[#111] min-h-screen transition-all"
>
    <div class="flex m-3 rounded-xl shadow bg-white h-full flex-col justify-between p-4">
        <div class="flex flex-col gap-4">

            <!-- Header -->
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="flex items-center justify-center text-white">
                    <span class="text-text-main dark:text-white text-2xl font-extrabold tracking-tight">
                        PinjamRuang<span class="text-primary">.</span>
                    </span>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-2 mt-4">

                @hasRole('kasubag')
                @php
                    $isDashboard  = request()->routeIs('kasubag.dashboard');
                    $isJadwal     = request()->routeIs('kasubag.jadwal-ruangan');
                    $isListUser   = request()->routeIs('kasubag.list-user');
                    $isMasterRuangan = request()->routeIs('kasubag.master-ruangan');
                    $isKelolaRuangan = request()->routeIs('kasubag.kelola-ruangan');
                    $isVerifikasiPeminjaman = request()->routeIs('kasubag.verifikasi-peminjaman');
                    $isRiwayatVerifikasi = request()->routeIs('kasubag.riwayat-verifikasi');
                    $isRiwayatPeminjaman = request()->routeIs('kasubag.riwayat-peminjaman');
                @endphp
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isDashboard ? 'bg-primary/10 text-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('kasubag.dashboard') }}"
                    >
                        <i class="fa-solid fa-border-all text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Dashboard
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isJadwal ? 'bg-primary/10 text-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('kasubag.jadwal-ruangan') }}"
                    >
                        <i class="fa-regular fa-calendar text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Jadwal
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isListUser ? 'bg-primary/10 text-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('kasubag.list-user') }}"
                    >
                        <i class="fa-regular fa-user text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Kelola Pengguna
                        </p>
                    </a>

                    <!-- Kelola Ruangan -->
                    <div class="flex flex-col">

                    <button
                        id="kelolaRuanganBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg {{ $isMasterRuangan || $isKelolaRuangan ? 'bg-primary/10 text-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-building text-text-main transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Ruangan
                            </p>
                        </div>

                        <i
                            id="kelolaRuanganIcon"
                            class="fa-solid fa-chevron-down text-xs text-text-main group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>

                    <div
                        id="kelolaRuanganSubmenu"
                        class="ml-6 mt-2 pl-4 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1 hidden"
                    >
                        <a
                            href="{{ route('kasubag.master-ruangan') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Master Ruangan
                        </a>

                        <a
                            href="{{ route('kasubag.kelola-ruangan') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Kelola Ruangan
                        </a>
                    </div>
                </div>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isVerifikasiPeminjaman ? 'bg-primary/10 text-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('kasubag.verifikasi-peminjaman') }}"
                    >
                        <i class="fa-solid fa-list-check text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Verifikasi Peminjaman
                        </p>
                    </a>

                <!-- Histori -->
                <div class="flex flex-col">

                    <button
                        id="RiwayatBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg {{ $isRiwayatVerifikasi || $isRiwayatPeminjaman ? 'bg-primary/10 text-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-clock-rotate-left text-text-main transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Riwayat
                            </p>
                        </div>

                        <i
                            id="riwayatIcon"
                            class="fa-solid fa-chevron-down text-xs text-text-main group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>

                    <div
                        id="riwayatSubmenu"
                        class="ml-6 mt-2 pl-4 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1 hidden"
                    >
                        <a
                            href="{{ route('kasubag.riwayat-verifikasi') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Riwayat Verifikasi
                        </a>

                        <a
                            href="{{ route('kasubag.riwayat-peminjaman') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Riwayat Peminjaman
                        </a>
                    </div>
                </div>
                @endhasRole


                <!-- Menu -->
            <nav class="flex flex-col gap-2 mt-4">

                @hasRole('sarpras')
                @php
                    $isDashboard  = request()->routeIs('sarpras.dashboard');
                    $isJadwal     = request()->routeIs('sarpras.kelola-jadwal');
                    $isVerifikasiPeminjaman = request()->routeIs('sarpras.verifikasi-peminjaman');
                    $isRiwayatVerifikasi = request()->routeIs('sarpras.riwayat-verifikasi');
                @endphp
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isDashboard ? 'bg-primary/10 dark:bg-gray-800' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('sarpras.dashboard') }}"
                    >
                        <i class="fa-solid fa-border-all text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Dashboard
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isJadwal ? 'bg-primary/10 dark:bg-gray-800' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('sarpras.kelola-jadwal') }}"
                    >
                        <i class="fa-regular fa-calendar text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Jadwal
                        </p>
                    </a>

                    {{-- <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('sarpras.kelola-ruangan') }}"
                    >
                        <i class="fa-solid fa-list-check text-text-secondary group-hover:text-primary transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Kelola Ruangan
                        </p>
                    </a> --}}
                    <div class="flex flex-col">

                    <button
                        id="verfikasiPeminjamanBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg {{ $isVerifikasiPeminjaman || $isRiwayatVerifikasi ? 'bg-primary/10 dark:bg-gray-800' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-building text-text-main transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Peminjaman
                            </p>
                        </div>

                        <i
                            id="verfikasiPeminjamanIcon"
                            class="fa-solid fa-chevron-down text-xs text-text-main group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>

                    <div
                        id="verfikasiPeminjamanSubmenu"
                        class="ml-6 mt-2 pl-4 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1 hidden"
                    >
                        <a
                            href="{{ route('sarpras.verifikasi-peminjaman') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Verifikasi Peminjaman
                        </a>

                        <a
                            href="{{ route('sarpras.riwayat-verifikasi') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Riwayat Verifikasi
                        </a>
                    </div>
                </div>
                @endhasRole

                @hasRole('pimpinan')
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('pimpinan.dashboard') }}"
                    >
                        <i class="fa-regular fa-house text-text-main group-hover:text-primary transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Dashboard
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('pimpinan.jadwal-ruangan') }}"
                    >
                        <i class="fa-regular fa-calendar text-text-main group-hover:text-primary transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Jadwal
                        </p>
                    </a>

                    {{-- <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                        href="{{ route('sarpras.kelola-ruangan') }}"
                    >
                        <i class="fa-solid fa-list-check text-text-secondary group-hover:text-primary transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Kelola Ruangan
                        </p>
                    </a> --}}
                    <div class="flex flex-col">

                    <button
                        id="verfikasiPeminjamanBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-door-open text-text-secondary group-hover:text-primary transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Peminjaman
                            </p>
                        </div>

                        <i
                            id="verfikasiPeminjamanIcon"
                            class="fa-solid fa-chevron-down text-xs text-text-secondary group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>

                    <div
                        id="verfikasiPeminjamanSubmenu"
                        class="ml-6 mt-2 pl-4 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1 hidden"
                    >
                        <a
                            href="{{ route('pimpinan.verifikasi-peminjaman') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Verifikasi Peminjaman
                        </a>

                        <a
                            href="{{ route('pimpinan.riwayat-verifikasi') }}"
                            class="relative flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-4 border-t border-gray-300 dark:border-gray-600"></span>
                            Riwayat Verifikasi
                        </a>
                    </div>
                </div>
                @endhasRole
                    {{-- <!-- Histori -->
                <div class="flex flex-col">

                    <button
                        id="RiwayatBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-clock-rotate-left text-text-secondary group-hover:text-primary transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Riwayat
                            </p>
                        </div>

                        <i
                            id="RiwayatIcon"
                            class="fa-solid text-xs text-text-secondary group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>
                </div> --}}

                @hasRole('ormawa')

                @php
                    $isDashboard  = request()->routeIs('ormawa.dashboard');
                    $isJadwal     = request()->routeIs('ormawa.jadwal-ruangan');
                    $isPeminjaman = request()->routeIs('ormawa.ajukan-peminjaman*'); // kalau ada create/store dll
                    $isRiwayat    = request()->routeIs('ormawa.riwayat-peminjaman*');
                @endphp
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isDashboard ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('ormawa.dashboard') }}"
                    >
                        <i class="fa-solid fa-border-all text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Dashboard
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isJadwal ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('ormawa.jadwal-ruangan') }}"
                    >
                        <i class="fa-regular fa-calendar text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Jadwal
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isPeminjaman ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('ormawa.ajukan-peminjaman') }}"
                    >
                        <i class="fa-regular fa-building text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Peminjaman
                        </p>
                    </a>
                    <!-- Histori -->
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isRiwayat ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('ormawa.riwayat-peminjaman') }}"
                    >
                        <i class="fa-solid fa-clock-rotate-left text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Riwayat
                        </p>
                    </a>
                @endhasRole

                @hasRole('mahasiswa')
                @php
                    $isDashboard  = request()->routeIs('mahasiswa.dashboard');
                    $isJadwal     = request()->routeIs('mahasiswa.jadwal-ruangan');
                    $isPeminjaman = request()->routeIs('mahasiswa.ajukan-peminjaman*'); // kalau ada create/store dll
                    $isRiwayat    = request()->routeIs('mahasiswa.riwayat-peminjaman*');
                @endphp

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isDashboard ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('mahasiswa.dashboard') }}"
                    >
                        <i class="fa-solid fa-house text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Dashboard
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isJadwal ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('mahasiswa.jadwal-ruangan') }}"
                    >
                        <i class="fa-solid fa-calendar text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Jadwal
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isPeminjaman ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('mahasiswa.ajukan-peminjaman') }}"
                    >
                        <i class="fa-solid fa-list-check text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Peminjaman
                        </p>
                    </a>
                    <!-- Histori -->
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isRiwayat ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('mahasiswa.riwayat-peminjaman') }}"
                    >
                        <i class="fa-solid fa-clock-rotate-left text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Riwayat
                        </p>
                    </a>
                @endhasRole

                @hasRole('dosen')
                @php
                    $isDashboard  = request()->routeIs('dosen.dashboard');
                    $isJadwal     = request()->routeIs('dosen.jadwal-ruangan');
                    $isPeminjaman = request()->routeIs('dosen.ajukan-peminjaman*');
                    $isRiwayat    = request()->routeIs('dosen.riwayat-peminjaman*');
                @endphp
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isDashboard ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('dosen.dashboard') }}"
                    >
                        <i class="fa-solid fa-house text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Dashboard
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isJadwal ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('dosen.jadwal-ruangan') }}"
                    >
                        <i class="fa-solid fa-calendar text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Jadwal
                        </p>
                    </a>

                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isPeminjaman ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('dosen.ajukan-peminjaman') }}"
                    >
                        <i class="fa-solid fa-list-check text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Peminjaman
                        </p>
                    </a>
                    <!-- Histori -->
                    <a
                        class="flex items-center gap-3 px-3 py-3 rounded-lg {{ $isRiwayat ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 dark:hover:bg-gray-800' }} transition-colors group"
                        href="{{ route('dosen.riwayat-peminjaman') }}"
                    >
                        <i class="fa-solid fa-clock-rotate-left text-text-main transition-colors"></i>
                        <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                            Riwayat
                        </p>
                    </a>
                @endhasRole

            </nav>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="flex w-full cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-4 text-text-main hover:bg-gray-200 transition-colors"
            >
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="text-sm font-bold leading-normal tracking-[0.015em]">
                    Logout
                </span>
            </button>
        </form>


    </div>
</aside>

@push("js")
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Kelola Ruangan
    const kelolaRuanganBtn = document.getElementById("kelolaRuanganBtn");
    const kelolaRuanganIcon = document.getElementById("kelolaRuanganIcon");
    const kelolaRuanganSubmenu = document.getElementById("kelolaRuanganSubmenu");

    if (kelolaRuanganBtn) {
        kelolaRuanganBtn.addEventListener("click", function () {
            kelolaRuanganSubmenu.classList.toggle("hidden");
            kelolaRuanganIcon.classList.toggle("rotate-180");
        });
    }

    // Histori
    const historiBtn = document.getElementById("HistoriBtn");
    const historiIcon = document.getElementById("HistoriIcon");
    const historiSubmenu = document.getElementById("HistoriSubmenu");

    if (historiBtn) {
        historiBtn.addEventListener("click", function () {
            historiSubmenu.classList.toggle("hidden");
            historiIcon.classList.toggle("rotate-180");
        });
    }

    // Peminjaman
    const peminjamanBtn = document.getElementById("PeminjamanBtn");
    const peminjamanIcon = document.getElementById("PeminjamanIcon");
    const peminjamanSubmenu = document.getElementById("PeminjamanSubmenu");

    if (peminjamanBtn) {
        peminjamanBtn.addEventListener("click", function () {
            peminjamanSubmenu.classList.toggle("hidden");
            peminjamanIcon.classList.toggle("rotate-180");
        });
    }

        // Verifikasi Peminjaman
        const verifikasiPeminjamanBtn = document.getElementById("verfikasiPeminjamanBtn");
        const verifikasiPeminjamanIcon = document.getElementById("verfikasiPeminjamanIcon");
        const verifikasiPeminjamanSubmenu = document.getElementById("verfikasiPeminjamanSubmenu");

        if (verifikasiPeminjamanBtn) {
            verifikasiPeminjamanBtn.addEventListener("click", function () {
                verifikasiPeminjamanSubmenu.classList.toggle("hidden");
                verifikasiPeminjamanIcon.classList.toggle("rotate-180");
            });
        }

        // Riwayat
        const riwayatBtn = document.getElementById("RiwayatBtn");
        const riwayatIcon = document.getElementById("riwayatIcon");
        const riwayatSubmenu = document.getElementById("riwayatSubmenu");

        if (riwayatBtn) {
            riwayatBtn.addEventListener("click", function () {
                riwayatSubmenu.classList.toggle("hidden");
                riwayatIcon.classList.toggle("rotate-180");
            });
        }

});
</script>
@endpush
