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
                        @foreach($peminjaman as $p)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $p->no_peminjaman }}
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $p->pemohon->nama_lengkap ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $p->ruangan->nama_ruang }} - {{ $p->ruangan->gedung->nama }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->translatedFormat('d F Y') }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $p->waktu_mulai }} - {{ $p->waktu_selesai }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($p->status == 'pending') bg-yellow-100 text-yellow-600
                                    @elseif($p->status == 'disetujui') bg-green-100 text-green-600
                                    @else bg-red-100 text-red-600
                                    @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button onclick="openModal(this)"
                                    data-no="{{ $p->no_peminjaman }}"
                                    data-nama="{{ $p->pemohon->nama_lengkap ?? '-' }}"
                                    data-nim="{{ $p->pemohon->nomor_induk ?? '-' }}"
                                    data-email="{{ $p->pemohon->email ?? '-' }}"
                                    data-ruangan="{{ $p->ruangan->nama_ruang }}"
                                    data-gedung="{{ $p->ruangan->gedung->nama }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->translatedFormat('d F Y') }}"
                                    data-waktu="{{ $p->waktu_mulai }} - {{ $p->waktu_selesai }}"
                                    data-kegiatan="{{ $p->kegiatan }}"
                                    data-dokumen="{{ $p->dokumen_bukti ? asset('storage/'.$p->dokumen_bukti) : '' }}"
                                    data-status="{{ $p->status }}"
                                    class="w-9 h-9 bg-blue-50 text-blue-500 rounded-lg">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination (TETAP ADA) -->
            {{ $peminjaman->links() }}
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
            <p id="modal_no" class="font-semibold text-lg text-slate-800"></p>
        </div>

        <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-2">
            <p class="text-xs text-slate-500 uppercase">Status</p>
            <span id="modal_status"
                class="inline-block px-3 py-1 text-xs font-semibold rounded-full">
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
                <p id="modal_nama" class="font-medium text-slate-800"></p>
            </div>

            <div>
                <p class="text-slate-500">Jenis Pengguna</p>
                <p class="font-medium text-slate-800">
                    Organisasi Mahasiswa
                </p>
            </div>

            <div>
                <p class="text-slate-500">NIM/NPM</p>
                <p id="modal_nim" class="font-medium text-slate-800"></p>
            </div>

            <div>
                <p class="text-slate-500">Email</p>
                <p id="modal_email" class="font-medium text-slate-800"></p>
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
                <p id="modal_ruangan" class="font-medium text-slate-800"></p>
            </div>

            <div>
                <p class="text-slate-500">Tanggal</p>
                <p id="modal_tanggal" class="font-medium text-slate-800"></p>
            </div>

            <div>
                <p class="text-slate-500">Waktu</p>
                <p id="modal_waktu" class="font-medium text-slate-800"></p>
            </div>

            <div class="md:col-span-2">
                <p class="text-slate-500">Kegiatan</p>
                <p id="modal_kegiatan" class="font-medium text-slate-800"></p>
            </div>

            <div class="md:col-span-2">
                <p class="text-slate-500">Dokumen Pendukung</p>
                <a id="modal_dokumen"
                    href="#"
                    target="_blank"
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
        function openModal(btn) {

            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');

            document.getElementById('modal_no').innerText = btn.dataset.no;
            document.getElementById('modal_status').innerText = btn.dataset.status;
            document.getElementById('modal_nama').innerText = btn.dataset.nama;
            document.getElementById('modal_nim').innerText = btn.dataset.nim;
            document.getElementById('modal_email').innerText = btn.dataset.email;

            document.getElementById('modal_ruangan').innerText =
                btn.dataset.ruangan + " - " + btn.dataset.gedung;

            document.getElementById('modal_tanggal').innerText = btn.dataset.tanggal;
            document.getElementById('modal_waktu').innerText = btn.dataset.waktu;
            document.getElementById('modal_kegiatan').innerText = btn.dataset.kegiatan;

            let dok = document.getElementById('modal_dokumen');

            if (btn.dataset.dokumen) {
                dok.href = btn.dataset.dokumen;
                dok.style.display = 'inline';
            } else {
                dok.style.display = 'none';
            }

            let statusEl = document.getElementById('modal_status');
            statusEl.innerText = btn.dataset.status;

            statusEl.className = "inline-block px-3 py-1 text-xs font-semibold rounded-full";

            if (btn.dataset.status === 'pending') {
                statusEl.classList.add('bg-yellow-100', 'text-yellow-600');
            } else if (btn.dataset.status === 'disetujui') {
                statusEl.classList.add('bg-green-100', 'text-green-600');
            } else {
                statusEl.classList.add('bg-red-100', 'text-red-600');
            }
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>

</x-master>
