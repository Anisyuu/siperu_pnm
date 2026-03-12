<x-master>
    <div class="bg-slate-100 min-h-screen px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                        Verifikasi Peminjaman
                    </h2>
                    <p class="text-slate-500 text-sm mt-1">
                        Kelola dan verifikasi seluruh pengajuan peminjaman ruangan
                    </p>
                </div>

                <button class="px-5 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-file-export mr-2"></i>
                    Ekspor Data
                </button>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        placeholder="Cari pemohon, ruangan, atau ID..."
                        class="flex-1 px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800"
                    />

                    <select class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">
                        <option>Semua Status</option>
                        <option>Menunggu</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                    </select>

                    <button type="submit"
                            class="h-11 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                        Terapkan
                    </button>

                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
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

                        <tbody class="divide-y divide-slate-200">

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4 font-medium text-slate-800">
                                    #PMJ-001
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            Annisya
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            Organisasi Mahasiswa
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    Aula Gedung A
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    20 Januari 2026
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    08.00 - 10.00
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600">
                                        Menunggu
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-4 text-slate-500">

                                        <!-- DETAIL ONLY -->
                                        <button onclick="openModal()"
                                            class="w-9 h-9 flex items-center justify-center bg-blue-50 border border-blue-200 text-blue-500 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition">
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

                <button class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm text-slate-700">
                    Previous
                </button>

                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 bg-primary text-white rounded-md text-sm shadow-sm">1</button>
                    <button class="px-3 py-1.5 border border-slate-200 bg-white rounded-md text-sm text-slate-700 hover:bg-slate-50">2</button>
                    <button class="px-3 py-1.5 border border-slate-200 bg-white rounded-md text-sm text-slate-700 hover:bg-slate-50">3</button>
                </div>

                <button class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm text-slate-700">
                    Next
                </button>

            </div>
        </div>
    </div>

    <!-- MODAL POPUP -->
    <div id="detailModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-50 px-4">

        <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl border border-slate-200 overflow-hidden relative animate-fadeIn">

            <!-- Header -->
            <div class="flex items-center justify-between px-8 py-6 border-b border-slate-200">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">
                        Detail Pengajuan
                    </h3>
                    <p class="text-sm text-slate-500">
                        Informasi lengkap pengajuan peminjaman
                    </p>
                </div>

                <button onclick="closeModal()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark text-lg text-slate-500"></i>
                </button>
            </div>

            <!-- Content -->
            <div class="px-8 py-6 space-y-6 max-h-[65vh] overflow-y-auto">

                <!-- Info Utama -->
                <div class="grid md:grid-cols-2 gap-6">

                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-2">
                        <p class="text-xs text-slate-500 uppercase">ID Pengajuan</p>
                        <p class="font-semibold text-lg text-slate-800">#PMJ-001</p>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-2">
                        <p class="text-xs text-slate-500 uppercase">Status</p>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600">
                            Menunggu
                        </span>
                    </div>

                </div>

                <!-- Data Pemohon -->
                <div>
                    <h4 class="font-semibold text-slate-700 mb-3">
                        Data Pemohon
                    </h4>

                    <div class="grid md:grid-cols-2 gap-6 text-sm">

                        <div>
                            <p class="text-slate-500">Nama</p>
                            <p class="font-medium text-slate-800">Annisya</p>
                        </div>

                        <div>
                            <p class="text-slate-500">Jenis Pengguna</p>
                            <p class="font-medium text-slate-800">
                                Organisasi Mahasiswa
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">NIM/NPM</p>
                            <p class="font-medium text-slate-800">
                                2212345678
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Email</p>
                            <p class="font-medium text-slate-800">
                                annisya@email.com
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Detail Peminjaman -->
                <div>
                    <h4 class="font-semibold text-slate-700 mb-3">
                        Detail Peminjaman
                    </h4>

                    <div class="grid md:grid-cols-2 gap-6 text-sm">

                        <div>
                            <p class="text-slate-500">Ruangan</p>
                            <p class="font-medium text-slate-800">
                                Aula Gedung A
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Tanggal</p>
                            <p class="font-medium text-slate-800">
                                20 Januari 2026
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Waktu</p>
                            <p class="font-medium text-slate-800">
                                08.00 - 10.00
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-slate-500">Keperluan</p>
                            <p class="font-medium text-slate-800">
                                Rapat Organisasi Tahunan
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-slate-500">Dokumen Pendukung</p>
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
            <div class="px-8 py-6 border-t border-slate-200 flex justify-end gap-4">

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
