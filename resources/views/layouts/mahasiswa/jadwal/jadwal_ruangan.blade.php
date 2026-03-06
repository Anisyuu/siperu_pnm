<x-master>
<div class="max-w-7xl mx-auto flex flex-col gap-8 p-10 rounded-2xl bg-white/80 dark:bg-gray-900/60 border border-border-subtle dark:border-gray-700">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Jadwal Ruangan
            </h2>
            <p class="text-text-secondary text-sm mt-1">
                Lihat dan filter jadwal penggunaan ruangan
            </p>
        </div>

        <div class="flex items-center gap-2 text-sm text-text-secondary bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-700">
            <i class="fa-regular fa-calendar-days"></i>
            <span>{{ now()->locale('id')->translatedFormat('d F Y') }}</span>
        </div>

    </div>


    <!-- FILTER SECTION -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-subtle dark:border-gray-700 shadow-sm p-5">
        <form class="flex flex-col md:flex-row gap-4 md:items-end">

            <!-- Pilih Ruangan -->
            <div class="flex flex-col flex-1">
                <label class="text-xs font-semibold text-text-secondary mb-1">
                    Ruangan
                </label>
                <select class="px-3 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none">
                    <option>Semua Ruangan</option>
                    <option>Ruang Alpha</option>
                    <option>Ruang Beta</option>
                    <option>Ruang Diskusi 1</option>
                </select>
            </div>

            <!-- Pilih Tanggal -->
            <div class="flex flex-col flex-1">
                <label class="text-xs font-semibold text-text-secondary mb-1">
                    Tanggal
                </label>
                <input type="date"
                    class="px-3 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none">
            </div>

            <!-- Status -->
            <div class="flex flex-col flex-1">
                <label class="text-xs font-semibold text-text-secondary mb-1">
                    Status
                </label>
                <select class="px-3 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none">
                    <option>Semua</option>
                    <option>Disetujui</option>
                    <option>Menunggu</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex shrink-0">
                <button type="submit"
                        class="h-10 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                    Terapkan
                </button>
            </div>

        </form>
    </div>

    <div class="flex flex-col gap-4">

                <div class="flex justify-end">
                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border border-border-subtle dark:border-gray-700 px-3 py-1.5 shadow-sm">
                    <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-text-secondary">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <span class="px-4 text-sm font-bold text-text-main dark:text-white">
                        Januari 2026
                    </span>

                    <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors text-text-secondary">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <div class="w-px h-4 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                    <button class="px-3 py-1 text-xs font-bold bg-primary text-white rounded-md shadow-sm">
                        Bulan
                    </button>

                    <button class="px-3 py-1 text-xs font-medium text-text-secondary hover:text-text-main rounded-md transition-colors">
                        Minggu
                    </button>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden flex flex-col h-[500px]">

                <div class="flex border-b border-border-subtle dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 z-20">
                    <div class="w-16 shrink-0 border-r border-border-subtle dark:border-gray-700 flex items-center justify-center p-2">
                        <span class="text-xs font-bold text-text-secondary">
                            GMT+7
                        </span>
                    </div>

                    <div class="flex-1 overflow-hidden">
                        <div class="grid grid-cols-7 w-full min-w-[700px]">

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center bg-primary/5 dark:bg-primary/10">
                                <p class="text-xs font-bold text-primary mb-1">Sen</p>
                                <div class="size-8 mx-auto flex items-center justify-center bg-primary text-white rounded-full font-bold text-sm shadow-md">
                                    23
                                </div>
                            </div>

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center group cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <p class="text-xs font-medium text-text-secondary mb-1 group-hover:text-primary">
                                    Sel
                                </p>
                                <div class="size-8 mx-auto flex items-center justify-center text-text-main dark:text-white font-bold text-sm">
                                    24
                                </div>
                            </div>

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center group cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <p class="text-xs font-medium text-text-secondary mb-1 group-hover:text-primary">
                                    Rab
                                </p>
                                <div class="size-8 mx-auto flex items-center justify-center text-text-main dark:text-white font-bold text-sm">
                                    25
                                </div>
                            </div>

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center group cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <p class="text-xs font-medium text-text-secondary mb-1 group-hover:text-primary">
                                    Kam
                                </p>
                                <div class="size-8 mx-auto flex items-center justify-center text-text-main dark:text-white font-bold text-sm">
                                    26
                                </div>
                            </div>

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center group cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <p class="text-xs font-medium text-text-secondary mb-1 group-hover:text-primary">
                                    Jum
                                </p>
                                <div class="size-8 mx-auto flex items-center justify-center text-text-main dark:text-white font-bold text-sm">
                                    27
                                </div>
                            </div>

                            <div class="p-3 border-r border-border-subtle dark:border-gray-700 text-center bg-gray-50/30 dark:bg-gray-800/50">
                                <p class="text-xs font-medium text-red-400 mb-1">Sab</p>
                                <div class="size-8 mx-auto flex items-center justify-center text-text-secondary font-bold text-sm">
                                    28
                                </div>
                            </div>

                            <div class="p-3 text-center bg-gray-50/30 dark:bg-gray-800/50">
                                <p class="text-xs font-medium text-red-400 mb-1">Min</p>
                                <div class="size-8 mx-auto flex items-center justify-center text-text-secondary font-bold text-sm">
                                    29
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto relative custom-scrollbar">
                    <div class="flex min-h-[600px]">

                        <div class="w-16 shrink-0 flex flex-col border-r border-border-subtle dark:border-gray-700 bg-white dark:bg-gray-800 sticky left-0 z-10">
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">08:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">09:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">10:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">11:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">12:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">13:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">14:00</span>
                            </div>
                            <div class="h-20 border-b border-border-subtle dark:border-gray-700/50 text-[10px] text-text-secondary p-1 text-center relative">
                                <span class="-top-2 relative bg-white dark:bg-gray-800 px-1">15:00</span>
                            </div>
                        </div>

                        <div class="flex-1 min-w-[700px] grid grid-cols-7 relative bg-white dark:bg-gray-800">

                            <div class="absolute inset-0 flex flex-col pointer-events-none">
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                                <div class="h-20 border-b border-border-subtle dark:border-gray-700/30 w-full border-dashed"></div>
                            </div>

                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full group">
                                <div class="absolute top-10 left-1 right-1 h-[60px] bg-primary/10 border-l-4 border-primary rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm">
                                    <p class="text-[11px] font-bold text-primary truncate">
                                        Brainstorming Q4
                                    </p>
                                    <p class="text-[10px] text-primary/80 truncate">
                                        08:30 - 09:30
                                    </p>
                                </div>
                            </div>

                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full">
                                <div class="absolute top-[180px] left-0 right-0 border-t-2 border-red-500 z-20 flex items-center">
                                    <div class="size-2 bg-red-500 rounded-full -ml-1"></div>
                                </div>
                            </div>

                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full">
                                <div class="absolute top-[20px] left-1 right-1 h-[140px] bg-purple-100 dark:bg-purple-900/40 border-l-4 border-purple-500 rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm">
                                    <p class="text-[11px] font-bold text-purple-700 dark:text-purple-300 truncate">
                                        Design Review Sprint
                                    </p>
                                    <p class="text-[10px] text-purple-600 dark:text-purple-400 truncate">
                                        08:15 - 10:45
                                    </p>
                                    <div class="mt-1 flex -space-x-1">
                                        <div class="size-4 rounded-full bg-gray-300 border border-white"></div>
                                        <div class="size-4 rounded-full bg-gray-400 border border-white"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full">
                                <div class="absolute top-[240px] left-1 right-1 h-[60px] bg-orange-100 dark:bg-orange-900/40 border-l-4 border-orange-500 rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm">
                                    <p class="text-[11px] font-bold text-orange-700 dark:text-orange-300 truncate">
                                        Client Meeting
                                    </p>
                                    <p class="text-[10px] text-orange-600 dark:text-orange-400 truncate">
                                        11:00 - 12:00
                                    </p>
                                </div>
                            </div>

                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full"></div>
                            <div class="border-r border-border-subtle dark:border-gray-700 relative h-full bg-gray-50/20 dark:bg-gray-800/20"></div>
                            <div class="relative h-full bg-gray-50/20 dark:bg-gray-800/20"></div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

</x-master>
