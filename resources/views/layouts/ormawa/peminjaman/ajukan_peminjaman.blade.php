<x-master>
<div class="max-w-7xl flex flex-col gap-8 p-10 rounded-2xl bg-white/80 shadow me-3">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Pengajuan Peminjaman
            </h2>
            <p class="text-text-secondary text-sm mt-1">
                Daftar pengajuan peminjaman ruangan
            </p>
        </div>

        <button class="px-5 py-2 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
            + Ajukan Peminjaman
        </button>
    </div>


    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">
        <div class="flex flex-col md:flex-row gap-3">

            <input
                type="text"
                placeholder="Cari kegiatan..."
                class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
            />

            <select class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800">
                <option>Semua Status</option>
                <option>Pending</option>
                <option>Disetujui</option>
                <option>Ditolak</option>
            </select>

            <button class="px-5 py-2 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
                Ekspor
            </button>

        </div>
    </div>


    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Kegiatan</th>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-border-subtle dark:divide-gray-700">

                    <!-- SAMPLE ROW 1 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-text-main dark:text-white">
                                Rapat Ormawa
                            </p>
                            <p class="text-xs text-text-secondary">
                                Pengajuan #PMJ-001
                            </p>
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Aula Gedung A
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            20 Feb 2026
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            08:00 - 10:00
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-900/40 dark:text-yellow-300">
                                Pending
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-4 text-text-secondary">

                                <button class="hover:text-primary transition">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                            </div>
                        </td>
                    </tr>


                    <!-- SAMPLE ROW 2 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-text-main dark:text-white">
                                Seminar Nasional
                            </p>
                            <p class="text-xs text-text-secondary">
                                Pengajuan #PMJ-002
                            </p>
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Ruang 2.1
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            22 Feb 2026
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            13:00 - 16:00
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/40 dark:text-green-300">
                                Disetujui
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-4 text-text-secondary">

                                <button class="hover:text-primary transition">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                            </div>
                        </td>
                    </tr>


                    <!-- EMPTY STATE -->
                    <tr>
                        <td colspan="6" class="text-center py-12 text-text-secondary">
                            Belum ada pengajuan peminjaman
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

    </div>


    <!-- Pagination (TETAP ADA) -->
        <div class="flex items-center justify-between">

            <button class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                Previous
            </button>

            <div class="flex items-center gap-2">
                <button class="px-3 py-1 bg-primary text-white rounded-md text-sm shadow-sm">1</button>
                <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm">2</button>
                <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm">3</button>
            </div>

            <button class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                Next
            </button>

        </div>
    </div>

</div>
</x-master>
