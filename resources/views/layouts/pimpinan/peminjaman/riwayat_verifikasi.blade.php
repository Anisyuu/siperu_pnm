<x-master>

<div class="max-w-7xl mx-auto flex flex-col gap-8 p-10 rounded-2xl bg-white/80 border-2 border-gray-200">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Riwayat Verifikasi
            </h2>

            <p class="text-text-secondary text-sm mt-1">
                Riwayat seluruh pengajuan yang telah diverifikasi
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
                placeholder="Cari ID, pemohon, atau ruangan..."
                class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
            />

            <select class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800">
                <option>Semua Status</option>
                <option>Disetujui</option>
                <option>Ditolak</option>
            </select>

            <input type="date"
                class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800"/>

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

                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 text-text-main uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">ID</th>
                        <th class="px-6 py-4 text-left">Pemohon</th>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Diverifikasi Oleh</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-border-subtle dark:divide-gray-700">

                    <!-- ROW -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <td class="px-6 py-4 font-medium text-text-main dark:text-white">
                            #PMJ-021
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-semibold text-text-main dark:text-white">
                                Annisya
                            </p>
                            <p class="text-xs text-text-secondary">
                                Organisasi Mahasiswa
                            </p>
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Aula Gedung A
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            20 Januari 2026
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Admin Fakultas
                        </td>

                        <td class="px-6 py-4">

                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full
                                bg-green-100 text-green-600
                                dark:bg-green-900/40 dark:text-green-300">
                                Disetujui
                            </span>

                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-4 text-text-secondary">

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

        <button
            class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
            Previous
        </button>

        <div class="flex items-center gap-2">
            <button class="px-3 py-1 bg-primary text-white rounded-md text-sm shadow-sm">1</button>
            <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm">2</button>
            <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm">3</button>
        </div>

        <button
            class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
            Next
        </button>

    </div>

</div>



<!-- ================= MODAL DETAIL RIWAYAT ================= -->
<div id="detailModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-900 w-full max-w-3xl rounded-3xl shadow-2xl">

        <!-- HEADER -->
        <div class="flex justify-between items-center px-8 py-6 border-b dark:border-gray-700">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                Detail Riwayat Verifikasi
            </h3>

            <button onclick="closeModal()"
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- CONTENT -->
        <div class="px-8 py-6 space-y-6">

            <div class="grid md:grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="text-gray-500">Status</p>
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Disetujui
                    </span>
                </div>

                <div>
                    <p class="text-gray-500">Diverifikasi Oleh</p>
                    <p class="font-medium text-gray-800 dark:text-white">
                        Admin Fakultas
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tanggal Verifikasi</p>
                    <p class="font-medium text-gray-800 dark:text-white">
                        18 Januari 2026
                    </p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-gray-500">Catatan Verifikator</p>
                    <p class="font-medium text-gray-800 dark:text-white">
                        Pengajuan disetujui sesuai jadwal kegiatan kampus.
                    </p>
                </div>

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
