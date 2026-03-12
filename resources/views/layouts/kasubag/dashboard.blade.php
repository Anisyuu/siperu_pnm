<x-master>
    <div class="bg-slate-100 min-h-screen px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div class="flex flex-col gap-1">
                    <h2 class="text-slate-900 text-3xl md:text-4xl font-extrabold tracking-tight">
                        Selamat Datang, {{ auth()->user()->nama_lengkap }}!
                    </h2>

                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <i class="fa-regular fa-calendar-days text-[16px]"></i>
                        <span id="realtime-date"></span>
                    </div>
                </div>
            </div>

            {{-- STATS CARD (TETAP STYLE LAMA) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">

                <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 border border-border-subtle dark:border-gray-700 shadow-sm group hover:border-primary/30 transition-all">
                    <div class="absolute right-3 top-3 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-calendar-days text-primary text-[80px] leading-none"></i>
                    </div>

                    <div class="flex flex-col gap-3 relative z-10">
                        <div class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-primary dark:text-blue-300">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>
                        <div>
                            <p class="text-text-secondary text-sm font-medium">
                                Peminjaman Aktif
                            </p>
                            <p class="text-text-main dark:text-white text-3xl font-bold mt-1">
                                8
                            </p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 border border-border-subtle dark:border-gray-700 shadow-sm group hover:border-yellow-500/30 transition-all">
                    <div class="absolute right-3 top-3 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-clock-rotate-left text-yellow-500 text-[80px] leading-none"></i>
                    </div>

                    <div class="flex flex-col gap-3 relative z-10">
                        <div class="size-10 rounded-full bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-300">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <p class="text-text-secondary text-sm font-medium">
                                Menunggu Persetujuan
                            </p>
                            <p class="text-text-main dark:text-white text-3xl font-bold mt-1">
                                3
                            </p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 border border-border-subtle dark:border-gray-700 shadow-sm group hover:border-red-500/30 transition-all">
                    <div class="absolute right-3 top-3 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-calendar-xmark text-red-500 text-[80px] leading-none"></i>
                    </div>

                    <div class="flex flex-col gap-3 relative z-10">
                        <div class="size-10 rounded-full bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-500 dark:text-red-300">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <div>
                            <p class="text-text-secondary text-sm font-medium">
                                Pengajuan Ditolak
                            </p>
                            <p class="text-text-main dark:text-white text-3xl font-bold mt-1">
                                1
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- SECTION JADWAL --}}
            <div class="flex flex-col gap-4 mt-6">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-slate-900 text-xl font-bold">
                            Jadwal Ruangan
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Lihat jadwal peminjaman ruangan di seluruh gedung kampus.
                        </p>
                    </div>

                    <div class="flex items-center bg-white rounded-lg border border-slate-200 p-1 shadow-sm">
                        <button class="p-1.5 hover:bg-slate-100 rounded-md transition-colors text-slate-500">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <span class="px-4 text-sm font-bold text-slate-800">
                            Januari 2026
                        </span>

                        <button class="p-1.5 hover:bg-slate-100 rounded-md transition-colors text-slate-500">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                        <div class="w-px h-4 bg-slate-200 mx-2"></div>

                        <button class="px-3 py-1 text-xs font-bold bg-primary text-white rounded-md shadow-sm">
                            Bulan
                        </button>

                        <button class="px-3 py-1 text-xs font-medium text-slate-500 hover:text-slate-800 rounded-md transition-colors">
                            Minggu
                        </button>
                    </div>
                </div>

                {{-- KALENDER --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[500px]">

                    <div class="flex border-b border-slate-200 bg-slate-50 z-20">
                        <div class="w-16 shrink-0 border-r border-slate-200 flex items-center justify-center p-2">
                            <span class="text-xs font-bold text-slate-500">
                                GMT+7
                            </span>
                        </div>

                        <div class="flex-1 overflow-hidden">
                            <div class="grid grid-cols-7 w-full min-w-[700px]">

                                <div class="p-3 border-r border-slate-200 text-center bg-primary/5">
                                    <p class="text-xs font-bold text-primary mb-1">Sen</p>
                                    <div class="size-8 mx-auto flex items-center justify-center bg-primary text-white rounded-full font-bold text-sm shadow-md">
                                        23
                                    </div>
                                </div>

                                <div class="p-3 border-r border-slate-200 text-center group cursor-pointer hover:bg-slate-50 transition-colors">
                                    <p class="text-xs font-medium text-slate-500 mb-1 group-hover:text-primary">
                                        Sel
                                    </p>
                                    <div class="size-8 mx-auto flex items-center justify-center text-slate-800 font-bold text-sm">
                                        24
                                    </div>
                                </div>

                                <div class="p-3 border-r border-slate-200 text-center group cursor-pointer hover:bg-slate-50 transition-colors">
                                    <p class="text-xs font-medium text-slate-500 mb-1 group-hover:text-primary">
                                        Rab
                                    </p>
                                    <div class="size-8 mx-auto flex items-center justify-center text-slate-800 font-bold text-sm">
                                        25
                                    </div>
                                </div>

                                <div class="p-3 border-r border-slate-200 text-center group cursor-pointer hover:bg-slate-50 transition-colors">
                                    <p class="text-xs font-medium text-slate-500 mb-1 group-hover:text-primary">
                                        Kam
                                    </p>
                                    <div class="size-8 mx-auto flex items-center justify-center text-slate-800 font-bold text-sm">
                                        26
                                    </div>
                                </div>

                                <div class="p-3 border-r border-slate-200 text-center group cursor-pointer hover:bg-slate-50 transition-colors">
                                    <p class="text-xs font-medium text-slate-500 mb-1 group-hover:text-primary">
                                        Jum
                                    </p>
                                    <div class="size-8 mx-auto flex items-center justify-center text-slate-800 font-bold text-sm">
                                        27
                                    </div>
                                </div>

                                <div class="p-3 border-r border-slate-200 text-center bg-slate-50/70">
                                    <p class="text-xs font-medium text-red-400 mb-1">Sab</p>
                                    <div class="size-8 mx-auto flex items-center justify-center text-slate-400 font-bold text-sm">
                                        28
                                    </div>
                                </div>

                                <div class="p-3 text-center bg-slate-50/70">
                                    <p class="text-xs font-medium text-red-400 mb-1">Min</p>
                                    <div class="size-8 mx-auto flex items-center justify-center text-slate-400 font-bold text-sm">
                                        29
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto relative custom-scrollbar">
                        <div class="flex min-h-[600px]">

                            <div class="w-16 shrink-0 flex flex-col border-r border-slate-200 bg-white sticky left-0 z-10">
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">08:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">09:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">10:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">11:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">12:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">13:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">14:00</span>
                                </div>
                                <div class="h-20 border-b border-slate-200/70 text-[10px] text-slate-500 p-1 text-center relative">
                                    <span class="-top-2 relative bg-white px-1">15:00</span>
                                </div>
                            </div>

                            <div class="flex-1 min-w-[700px] grid grid-cols-7 relative bg-white">

                                <div class="absolute inset-0 flex flex-col pointer-events-none">
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                    <div class="h-20 border-b border-slate-200/70 w-full border-dashed"></div>
                                </div>

                                <div class="border-r border-slate-200 relative h-full group">
                                    <div class="absolute top-10 left-1 right-1 h-[60px] bg-primary/10 border-l-4 border-primary rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm">
                                        <p class="text-[11px] font-bold text-primary truncate">
                                            Brainstorming Q4
                                        </p>
                                        <p class="text-[10px] text-primary/80 truncate">
                                            08:30 - 09:30
                                        </p>
                                    </div>
                                </div>

                                <div class="border-r border-slate-200 relative h-full">
                                    <div class="absolute top-[180px] left-0 right-0 border-t-2 border-red-500 z-20 flex items-center">
                                        <div class="size-2 bg-red-500 rounded-full -ml-1"></div>
                                    </div>
                                </div>

                                <div class="border-r border-slate-200 relative h-full">
                                    <div class="absolute top-[20px] left-1 right-1 h-[140px] bg-purple-100 border-l-4 border-purple-500 rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm">
                                        <p class="text-[11px] font-bold text-purple-700 truncate">
                                            Design Review Sprint
                                        </p>
                                        <p class="text-[10px] text-purple-600 truncate">
                                            08:15 - 10:45
                                        </p>
                                        <div class="mt-1 flex -space-x-1">
                                            <div class="size-4 rounded-full bg-gray-300 border border-white"></div>
                                            <div class="size-4 rounded-full bg-gray-400 border border-white"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-r border-slate-200 relative h-full">
                                    <div class="absolute top-[240px] left-1 right-1 h-[60px] bg-orange-100 border-l-4 border-orange-500 rounded p-2 hover:brightness-95 cursor-pointer z-10 shadow-sm">
                                        <p class="text-[11px] font-bold text-orange-700 truncate">
                                            Client Meeting
                                        </p>
                                        <p class="text-[10px] text-orange-600 truncate">
                                            11:00 - 12:00
                                        </p>
                                    </div>
                                </div>

                                <div class="border-r border-slate-200 relative h-full"></div>
                                <div class="border-r border-slate-200 relative h-full bg-slate-50/50"></div>
                                <div class="relative h-full bg-slate-50/50"></div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    @push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateDate() {
                const now = new Date();

                const hari = [
                    "Minggu",
                    "Senin",
                    "Selasa",
                    "Rabu",
                    "Kamis",
                    "Jum'at",
                    "Sabtu"
                ];

                const bulan = [
                    "Januari","Februari","Maret","April","Mei","Juni",
                    "Juli","Agustus","September","Oktober","November","Desember"
                ];

                const namaHari = hari[now.getDay()];
                const tanggal = now.getDate();
                const namaBulan = bulan[now.getMonth()];
                const tahun = now.getFullYear();

                const formatTanggal = `${namaHari}, ${tanggal} ${namaBulan} ${tahun}`;
                document.getElementById("realtime-date").textContent = formatTanggal;
            }

            updateDate();
            setInterval(updateDate, 60000);
        });
    </script>
    @endpush
</x-master>
