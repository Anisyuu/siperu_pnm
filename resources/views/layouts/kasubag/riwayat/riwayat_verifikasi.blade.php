<x-master>
    <div class="bg-slate-100 min-h-screen px-8 py-10">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Riwayat Verifikasi
                </h1>

                <p class="text-slate-500 mt-1 text-sm">
                    Riwayat seluruh pengajuan yang telah diverifikasi.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-5 py-3">
                    <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-clipboard-check text-emerald-500 text-sm"></i>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Total Verifikasi</div>
                        <div class="text-xl font-extrabold text-slate-800">
                            {{ "1" }}
                        </div>
                    </div>
                </div>

                <button
                    class="px-5 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-file-export mr-2"></i>
                    Ekspor Riwayat
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto flex flex-col gap-6">

            {{-- FILTER --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <form class="flex flex-col md:flex-row gap-4 md:items-end">

                    <div class="flex flex-col flex-1">
                        <label class="text-xs font-semibold text-slate-500 mb-1">
                            Cari
                        </label>
                        <input
                            type="text"
                            placeholder="Cari ID, pemohon, atau ruangan..."
                            class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none"
                        />
                    </div>

                    <div class="flex flex-col flex-1">
                        <label class="text-xs font-semibold text-slate-500 mb-1">
                            Status
                        </label>
                        <select
                            class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none">
                            <option>Semua Status</option>
                            <option>Disetujui</option>
                            <option>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex flex-col flex-1">
                        <label class="text-xs font-semibold text-slate-500 mb-1">
                            Tanggal
                        </label>
                        <input
                            type="date"
                            class="px-4 py-2.5 text-sm rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary focus:outline-none"
                        />
                    </div>

                    <div class="flex shrink-0 gap-3">
                        <button
                            type="submit"
                            class="h-11 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition">
                            Terapkan
                        </button>

                        <button
                            type="button"
                            class="h-11 px-6 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 uppercase text-xs tracking-wider text-slate-600">
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

                        <tbody class="divide-y divide-slate-200">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 align-top">
                                    <span class="font-semibold text-slate-800">
                                        #PMJ-021
                                    </span>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-slate-800">
                                        Annisya
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Organisasi Mahasiswa
                                    </p>
                                </td>

                                <td class="px-6 py-4 align-top text-slate-600">
                                    Aula Gedung A
                                </td>

                                <td class="px-6 py-4 align-top text-slate-600">
                                    20 Januari 2026
                                </td>

                                <td class="px-6 py-4 align-top text-slate-600">
                                    Admin Fakultas
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-600">
                                        Disetujui
                                    </span>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex justify-center items-center gap-3">
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

            {{-- PAGINATION --}}
            <div class="flex items-center justify-between flex-wrap gap-3">
                <button
                    class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm text-slate-700">
                    Previous
                </button>

                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 bg-primary text-white rounded-md text-sm shadow-sm">
                        1
                    </button>
                    <button class="px-3 py-1.5 border border-slate-200 bg-white rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        2
                    </button>
                    <button class="px-3 py-1.5 border border-slate-200 bg-white rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        3
                    </button>
                </div>

                <button
                    class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm text-slate-700">
                    Next
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-50 px-4">

        <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">
            <div class="flex justify-between items-center px-8 py-6 border-b border-slate-200">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        Detail Riwayat Verifikasi
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Informasi lengkap hasil verifikasi pengajuan.
                    </p>
                </div>

                <button onclick="closeModal()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark text-slate-600"></i>
                </button>
            </div>

            <div class="px-8 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">
                            Status
                        </p>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-600">
                            Disetujui
                        </span>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-1">
                            Diverifikasi Oleh
                        </p>
                        <p class="font-semibold text-slate-800">
                            Admin Fakultas
                        </p>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-1">
                            Tanggal Verifikasi
                        </p>
                        <p class="font-semibold text-slate-800">
                            18 Januari 2026
                        </p>
                    </div>

                    <div class="md:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-1">
                            Catatan Verifikator
                        </p>
                        <p class="font-semibold text-slate-800">
                            Pengajuan disetujui sesuai jadwal kegiatan kampus.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-200 flex justify-end">
                <button onclick="closeModal()"
                    class="px-5 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition text-sm font-medium">
                    Tutup
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
            document.getElementById('detailModal').classList.remove('flex');
        }
    </script>
</x-master>
