<aside
    class="hidden md:flex w-64 flex-col border-r border-border-subtle bg-white dark:bg-[#111] h-full transition-all"
>
    <div class="flex h-full flex-col justify-between p-4">
        <div class="flex flex-col gap-4">

            <!-- Header -->
            <div class="px-2 py-3 flex items-center gap-2">
                <div class="flex items-center justify-center text-white">
                    <img
                        src="https://pnm.ac.id/metronic/demo20/dist/assets/media/auth/pnm-logo.png"
                        alt="Logo SiPeru"
                        class="w-full h-auto object-contain"
                    />
                </div>

                {{--
                <h1 class="text-text-main dark:text-white text-xl font-bold leading-normal">
                    SiPeru PNM
                </h1>
                --}}
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-2 mt-4">

                <a
                    class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('superadmin.dashboard') ? 'bg-primary/10 bg-amber-600 border-l-4 border-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    href="{{ route('superadmin.dashboard') }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-table-dashed text-primary size-4"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -14"/>
                        <path d="M3 10h18"/>
                        <path d="M10 3v18"/>
                    </svg>

                    <p class="{{ request()->routeIs('superadmin.dashboard') ? 'text-primary' : 'text-text-main' }} dark:text-gray-300 text-sm font-medium leading-normal">
                        Dashboard
                    </p>
                </a>

                <a
                    class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('superadmin.jadwal.index') ? 'bg-primary/10 bg-amber-600 border-l-4 border-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    href="{{ route('superadmin.jadwal.index') }}"
                >
                    <i class="fa-regular fa-calendar text-text-secondary group-hover:text-primary transition-colors"></i>
                    <p class="{{ request()->routeIs('superadmin.jadwal.index') ? 'text-primary' : 'text-text-main' }} dark:text-gray-300 text-sm font-medium leading-normal">
                        Jadwal
                    </p>
                </a>

                <a
                    class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->routeIs('superadmin.data_pengajuan.index') ? 'bg-primary/10 bg-amber-600 border-l-4 border-primary' : '' }} hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    href="{{ route('superadmin.data_pengajuan.index') }}"
                >
                    <i class="fa-regular fa-newspaper text-text-secondary group-hover:text-primary transition-colors"></i>
                    <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                        Data Pengajuan
                    </p>
                </a>

                {{--
                <a
                    class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    href="#"
                >
                    <i class="fa-solid fa-door-open text-text-secondary group-hover:text-primary transition-colors"></i>
                    <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                        Kelola Ruangan
                    </p>
                </a>
                --}}

                <div class="flex flex-col">
                    <!-- Parent Menu -->
                    <button
                        id="kelolaRuanganBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-door-open text-text-secondary group-hover:text-primary transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Kelola Ruangan
                            </p>
                        </div>

                        <i
                            id="kelolaRuanganIcon"
                            class="fa-solid fa-chevron-down text-xs text-text-secondary group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>

                    <!-- Submenu -->
                    <div
                        id="kelolaRuanganSubmenu"
                        class="ml-10 mt-1 flex flex-col gap-1 hidden"
                    >
                        <a
                            href="#"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-semibold text-text-main dark:text-gray-300 hover:bg-primary/10 transition-colors"
                        >
                            <i class="fa-regular fa-circle text-[10px]"></i>
                            Data Ruangan
                        </a>

                        <a
                            href="#"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-semibold text-text-main dark:text-gray-300 hover:bg-primary/10 transition-colors"
                        >
                            <i class="fa-regular fa-circle text-[10px]"></i>
                            Master Ruangan
                        </a>
                    </div>
                </div>

                <div class="flex flex-col">
                    <!-- Parent Menu -->
                    <button
                        id="HistoriBtn"
                        type="button"
                        class="flex items-center justify-between gap-3 px-3 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-gray-800 transition-colors group"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-clock-rotate-left text-text-secondary group-hover:text-primary transition-colors"></i>
                            <p class="text-text-main dark:text-gray-300 text-sm font-medium leading-normal">
                                Histori
                            </p>
                        </div>

                        <i
                            id="HistoriIcon"
                            class="fa-solid fa-chevron-down text-xs text-text-secondary group-hover:text-primary transition-transform duration-200"
                        ></i>
                    </button>

                    <!-- Submenu -->
                    <div
                        id="HistoriSubmenu"
                        class="ml-10 mt-1 flex flex-col gap-1 hidden"
                    >
                        <a
                            href="#"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-semibold text-text-main dark:text-gray-300 hover:bg-primary/10 transition-colors"
                        >
                            <i class="fa-regular fa-circle text-[10px]"></i>
                            Histori Peminjaman
                        </a>

                        <a
                            href="#"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-semibold text-text-main dark:text-gray-300 hover:bg-primary/10 transition-colors"
                        >
                            <i class="fa-regular fa-circle text-[10px]"></i>
                            Histori Verifikasi
                        </a>
                    </div>
                </div>

            </nav>
        </div>

        <!-- Button -->
        <button
            class="flex w-full cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-4 bg-red-500 text-white hover:bg-red-700 transition-colors shadow-lg shadow-primary/20"
        >
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="text-sm font-bold leading-normal tracking-[0.015em]">
                Logout
            </span>
        </button>
    </div>
</aside>

@push("js")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const kelolaRuanganBtn = document.getElementById("kelolaRuanganBtn");
        const kelolaRuanganIcon = document.getElementById("kelolaRuanganIcon");
        const kelolaRuanganSubmenu = document.getElementById("kelolaRuanganSubmenu");

        const historiBtn = document.getElementById("HistoriBtn");
        const historiIcon = document.getElementById("HistoriIcon");
        const historiSubmenu = document.getElementById("HistoriSubmenu");

        kelolaRuanganBtn.addEventListener("click", function () {
            kelolaRuanganSubmenu.classList.toggle("hidden");
            kelolaRuanganIcon.classList.toggle("rotate-180");
        });

        historiBtn.addEventListener("click", function () {
            historiSubmenu.classList.toggle("hidden");
            historiIcon.classList.toggle("rotate-180");
        });
    });
</script>
@endpush
