<x-master>
    <div class="bg-slate-100 min-h-screen px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                        Pengajuan Peminjaman
                    </h2>
                    <p class="text-slate-500 text-sm mt-1">
                        Daftar pengajuan peminjaman ruangan
                    </p>
                </div>

                <button class="px-5 py-3 bg-primary text-white rounded-2xl shadow-sm hover:brightness-110 transition">
                    + Ajukan Peminjaman
                </button>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        placeholder="Cari kegiatan..."
                        class="flex-1 px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800"
                    />

                    <select class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none text-slate-800">
                        <option>Semua Status</option>
                        <option>Pending</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                    </select>

                    <button class="px-5 py-2.5 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
                        Ekspor
                    </button>

                </div>
            </div>

            <!-- TABLE -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <!-- HEADER -->
                        <thead class="bg-slate-50 border-b border-slate-200 uppercase text-xs tracking-wider text-slate-600">
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
                        <tbody class="divide-y divide-slate-200">

                            <!-- SAMPLE ROW 1 -->
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">
                                        Rapat Ormawa
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Pengajuan #PMJ-001
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    Aula Gedung A
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    20 Feb 2026
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    08:00 - 10:00
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600">
                                        Pending
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4 text-slate-500">

                                        <button class="w-9 h-9 flex items-center justify-center bg-blue-50 border border-blue-200 text-blue-500 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <!-- SAMPLE ROW 2 -->
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">
                                        Seminar Nasional
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Pengajuan #PMJ-002
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    Ruang 2.1
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    22 Feb 2026
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    13:00 - 16:00
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                                        Disetujui
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4 text-slate-500">

                                        <button class="w-9 h-9 flex items-center justify-center bg-blue-50 border border-blue-200 text-blue-500 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <!-- EMPTY STATE -->
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-500">
                                    Belum ada pengajuan peminjaman
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
</x-master>
