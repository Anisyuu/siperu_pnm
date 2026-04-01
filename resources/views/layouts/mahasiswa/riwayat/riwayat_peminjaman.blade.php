<x-master>
    <div class="bg-slate-100 min-h-screen px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            <!-- HEADER -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">

                <div>
                    <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                        Riwayat Peminjaman
                    </h2>

                    <p class="text-slate-500 text-sm mt-1">
                        Riwayat seluruh peminjaman ruangan yang pernah diajukan
                    </p>
                </div>

                <button
                    class="px-5 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-file-export mr-2"></i>
                    Ekspor Riwayat
                </button>

            </div>

            <!-- FILTER -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

                <div class="flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        placeholder="Cari kegiatan atau ruangan..."
                        class="flex-1 px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800"
                    />

                    <select
                        class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">
                        <option>Semua Status</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                        <option>Selesai</option>
                    </select>

                    <input type="date"
                        class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">

                    <button
                        class="h-11 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                        Terapkan
                    </button>

                </div>

            </div>

            <!-- TABLE -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-slate-50 border-b border-slate-200 uppercase text-xs tracking-wider text-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left">Kegiatan</th>
                                <th class="px-6 py-4 text-left">Ruangan</th>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Waktu</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">

                            <!-- SELESAI -->
                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">
                                        Workshop UI/UX
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Pengajuan #PMJ-010
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    Aula Gedung A
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    10 Januari 2026
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    08:00 - 12:00
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-600">
                                        Selesai
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4 text-slate-500">
                                        <button onclick="openModal()"
                                            class="w-9 h-9 flex items-center justify-center bg-blue-50 border border-blue-200 text-blue-500 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>

                            <!-- DITOLAK -->
                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">
                                        Seminar Nasional
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Pengajuan #PMJ-008
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    Ruang 2.1
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    05 Januari 2026
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    13:00 - 16:00
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                                        Ditolak
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4 text-slate-500">
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

            <!-- PAGINATION -->
            <div class="flex items-center justify-between">

                <button class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm text-slate-700">
                    Previous
                </button>

                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 bg-primary text-white rounded-md text-sm shadow-sm">1</button>
                    <button class="px-3 py-1.5 border border-slate-200 bg-white rounded-md text-sm text-slate-700 hover:bg-slate-50">2</button>
                </div>

                <button class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm text-slate-700">
                    Next
                </button>

            </div>

        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div id="detailModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-50 px-4">

        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

            <div class="flex justify-between items-center px-8 py-6 border-b border-slate-200">
                <h3 class="text-xl font-bold text-slate-900">
                    Detail Riwayat Peminjaman
                </h3>

                <button onclick="closeModal()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark text-slate-600"></i>
                </button>
            </div>

            <div class="px-8 py-6 space-y-4 text-sm">

                <div>
                    <p class="text-slate-500">Kegiatan</p>
                    <p class="font-medium text-slate-800">Workshop UI/UX</p>
                </div>

                <div>
                    <p class="text-slate-500">Ruangan</p>
                    <p class="font-medium text-slate-800">Aula Gedung A</p>
                </div>

                <div>
                    <p class="text-slate-500">Tanggal & Waktu</p>
                    <p class="font-medium text-slate-800">10 Januari 2026 | 08:00 - 12:00</p>
                </div>

                <div>
                    <p class="text-slate-500">Status</p>
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
