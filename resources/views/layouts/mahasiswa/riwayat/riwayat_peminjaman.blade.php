<x-master>

<div class="max-w-7xl mx-auto flex flex-col gap-8 p-10 rounded-2xl bg-white/80 border-2 border-gray-200">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Riwayat Peminjaman
            </h2>

            <p class="text-text-secondary text-sm mt-1">
                Riwayat seluruh peminjaman ruangan yang pernah diajukan
            </p>
        </div>

        <button
            class="px-5 py-2 border border-border-subtle rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            Ekspor Riwayat
        </button>

    </div>


    <!-- FILTER -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">

        <div class="flex flex-col md:flex-row gap-3">

            <input
                type="text"
                placeholder="Cari kegiatan atau ruangan..."
                class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
            />

            <select
                class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800">
                <option>Semua Status</option>
                <option>Disetujui</option>
                <option>Ditolak</option>
                <option>Selesai</option>
            </select>

            <input type="date"
                class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800">

            <button
                class="h-10 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                Terapkan
            </button>

        </div>

    </div>


    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 uppercase text-xs tracking-wider text-text-main">
                    <tr>
                        <th class="px-6 py-4 text-left">Kegiatan</th>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-border-subtle dark:divide-gray-700">

                    <!-- SELESAI -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <td class="px-6 py-4">
                            <p class="font-semibold text-text-main dark:text-white">
                                Workshop UI/UX
                            </p>
                            <p class="text-xs text-text-secondary">
                                Pengajuan #PMJ-010
                            </p>
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Aula Gedung A
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            10 Januari 2026
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            08:00 - 12:00
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                bg-blue-100 text-blue-600
                                dark:bg-blue-900/40 dark:text-blue-300">
                                Selesai
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-4 text-text-secondary">
                                <button onclick="openModal()" class="hover:text-primary transition">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </td>

                    </tr>


                    <!-- DITOLAK -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <td class="px-6 py-4">
                            <p class="font-semibold text-text-main dark:text-white">
                                Seminar Nasional
                            </p>
                            <p class="text-xs text-text-secondary">
                                Pengajuan #PMJ-008
                            </p>
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Ruang 2.1
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            05 Januari 2026
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            13:00 - 16:00
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                bg-red-100 text-red-600
                                dark:bg-red-900/40 dark:text-red-300">
                                Ditolak
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-4 text-text-secondary">
                                <button onclick="openModal()" class="hover:text-primary transition">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </td>

                    </tr>

                </tbody>

            </table>
        </div>

    </div>


    <!-- PAGINATION -->
    <div class="flex items-center justify-between">

        <button class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
            Previous
        </button>

        <div class="flex items-center gap-2">
            <button class="px-3 py-1 bg-primary text-white rounded-md text-sm shadow-sm">1</button>
            <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm">2</button>
        </div>

        <button class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
            Next
        </button>

    </div>

</div>

<!-- MODAL DETAIL -->
<div id="detailModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-900 w-full max-w-2xl rounded-3xl shadow-2xl">

        <div class="flex justify-between items-center px-8 py-6 border-b dark:border-gray-700">
            <h3 class="text-xl font-bold dark:text-white">
                Detail Riwayat Peminjaman
            </h3>

            <button onclick="closeModal()"
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="px-8 py-6 space-y-4 text-sm">

            <div>
                <p class="text-gray-500">Kegiatan</p>
                <p class="font-medium dark:text-white">Workshop UI/UX</p>
            </div>

            <div>
                <p class="text-gray-500">Ruangan</p>
                <p class="font-medium dark:text-white">Aula Gedung A</p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal & Waktu</p>
                <p class="font-medium dark:text-white">10 Januari 2026 | 08:00 - 12:00</p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                    Selesai
                </span>
            </div>

        </div>

    </div>

</div>


<script>
function openModal(){
    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('detailModal').classList.add('hidden');
}
</script>

</x-master>
