<x-master>
        <div class="bg-slate-100 min-h-screen px-8 py-10">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-8 flex-wrap gap-4">

            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Verifikasi Peminjaman
                </h1>

                <p class="text-slate-500 mt-1 text-sm">
                    Kelola seluruh pengajuan peminjaman ruangan yang masuk dan lakukan verifikasi.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">

                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-tags text-blue-500 text-sm"></i>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Total Pengajuan</div>
                        <div class="text-lg font-bold text-slate-800">
                          {{ "10" }}
                        </div>
                    </div>

                </div>


            </div>
        </div>

    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        <!-- Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-3">

                <input
                    type="text"
                    placeholder="Cari pemohon, ruangan, atau ID..."
                    class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
                />

                <select class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Disetujui</option>
                    <option>Ditolak</option>
                </select>

                <button type="submit"
                        class="h-10 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                    Terapkan
                </button>

            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 text-text-main uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Pemohon</th>
                            <th class="px-6 py-4 text-left">Ruangan</th>
                            <th class="px-6 py-4 text-left">Tanggal</th>
                            <th class="px-6 py-4 text-left">Waktu</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border-subtle dark:divide-gray-700">

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                            <td class="px-6 py-4 font-medium text-text-main dark:text-white">
                                #PMJ-001
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-text-main dark:text-white">
                                        Annisya
                                    </p>
                                    <p class="text-xs text-text-secondary">
                                        Organisasi Mahasiswa
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                Aula Gedung A
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                20 Januari 2026
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                08.00 - 10.00
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600">
                                    Menunggu
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-4 text-text-secondary">

                                    <!-- DETAIL ONLY -->
                                    <button onclick="openModal()" 
                                    class="w-8 h-8 flex items-center justify-center bg-blue-200/40 border border-blue-300 text-blue-500 rounded-lg hover:bg-blue-300/50 hover:border-blue-400 transition-all">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                </div>
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

    <!-- MODAL POPUP -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-900 w-full max-w-3xl rounded-3xl shadow-2xl relative animate-fadeIn">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Detail Pengajuan
                </h3>
                <p class="text-sm text-gray-500">
                    Informasi lengkap pengajuan peminjaman
                </p>
            </div>

            <button onclick="closeModal()"
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="fa-solid fa-xmark text-lg text-gray-500"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="px-8 py-6 space-y-6 max-h-[65vh] overflow-y-auto">

            <!-- Info Utama -->
            <div class="grid md:grid-cols-2 gap-6">

                <div class="bg-gray-50 dark:bg-gray-800 p-5 rounded-xl space-y-2">
                    <p class="text-xs text-gray-500 uppercase">ID Pengajuan</p>
                    <p class="font-semibold text-lg text-gray-800 dark:text-white">#PMJ-001</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 p-5 rounded-xl space-y-2">
                    <p class="text-xs text-gray-500 uppercase">Status</p>
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-900/40 dark:text-yellow-300">
                        Menunggu
                    </span>
                </div>

            </div>

            <!-- Data Pemohon -->
            <div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    Data Pemohon
                </h4>

                <div class="grid md:grid-cols-2 gap-6 text-sm">

                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-medium text-gray-800 dark:text-white">Annisya</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Jenis Pengguna</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            Organisasi Mahasiswa
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">NIM/NPM</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            2212345678
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            annisya@email.com
                        </p>
                    </div>

                </div>
            </div>

            <!-- Detail Peminjaman -->
            <div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    Detail Peminjaman
                </h4>

                <div class="grid md:grid-cols-2 gap-6 text-sm">

                    <div>
                        <p class="text-gray-500">Ruangan</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            Aula Gedung A
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Tanggal</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            20 Januari 2026
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Waktu</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            08.00 - 10.00
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-gray-500">Keperluan</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            Rapat Organisasi Tahunan
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-gray-500">Dokumen Pendukung</p>
                        <a href="#"
                            class="inline-flex items-center gap-2 text-primary font-medium hover:underline">
                            <i class="fa-solid fa-file"></i>
                            Lihat Dokumen
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <!-- Footer Action -->
        <div class="px-8 py-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">

            <button
                class="px-5 py-2.5 rounded-xl border border-red-500 text-red-500 hover:bg-red-50 transition font-medium">
                Tolak
            </button>

            <button
                class="px-5 py-2.5 rounded-xl bg-green-600 text-white hover:bg-green-700 transition font-medium shadow-md">
                Setujui
            </button>

        </div>

    </div>
</div>

    <script>
        function openModal() {
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>

</x-master>
