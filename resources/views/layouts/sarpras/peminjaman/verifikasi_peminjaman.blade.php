<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">Verifikasi Peminjaman</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola dan verifikasi seluruh pengajuan peminjaman ruangan</p>
        </div>
        <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
            <i class="fa-solid fa-file-export text-slate-400"></i>
            Ekspor Data
        </button>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-inbox text-slate-500 text-sm"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $peminjaman->total() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-clock text-amber-500 text-sm"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $peminjaman->getCollection()->where('status','pending')->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-circle-check text-green-500 text-sm"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Disetujui</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $peminjaman->getCollection()->where('status','disetujui')->count() }}</p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-circle-xmark text-red-400 text-sm"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ditolak</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $peminjaman->getCollection()->where('status','ditolak')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama pemohon, ruangan, atau nomor peminjaman..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition">
            </div>
            <select name="status"
                class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition">
                <option value="">Semua Status</option>
                <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak"   {{ request('status') === 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit"
                class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200">
                Terapkan
            </button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ request()->url() }}"
                class="px-4 py-2.5 border border-slate-200 text-sm text-slate-500 font-semibold rounded-xl hover:bg-slate-50 transition">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No. Peminjaman</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pemohon</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ruangan</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Waktu</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                @forelse($peminjaman as $p)
                <tr class="hover:bg-slate-50/70 transition-colors group">

                    {{-- No Peminjaman --}}
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">
                            {{ $p->no_peminjaman }}
                        </span>
                    </td>

                    {{-- Pemohon --}}
                    <td class="px-4 py-4">
                        @php $pemohon = $p->pemohon; @endphp
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($pemohon->nama_lengkap ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm leading-tight">{{ $pemohon->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $pemohon->nomor_induk ?? '-' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Ruangan --}}
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-700 text-sm leading-tight">{{ $p->ruangan->nama_ruang }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $p->ruangan->gedung->nama }} · Lt.{{ $p->ruangan->lantai }}
                        </p>
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-4 py-4 text-sm text-slate-600">
                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->locale('id')->translatedFormat('d M Y') }}
                        @if($p->tanggal_mulai !== $p->tanggal_selesai)
                            <div class="text-xs text-slate-400">
                                s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->locale('id')->translatedFormat('d M Y') }}
                            </div>
                        @endif
                    </td>

                    {{-- Waktu --}}
                    <td class="px-4 py-4 text-sm text-slate-600 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($p->waktu_mulai)->format('H:i') }} –
                        {{ \Carbon\Carbon::parse($p->waktu_selesai)->format('H:i') }}
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-4">
                        @php
                            $badge = match($p->status) {
                                'disetujui' => 'bg-green-50 text-green-700 border border-green-100',
                                'ditolak'   => 'bg-red-50 text-red-600 border border-red-100',
                                default     => 'bg-amber-50 text-amber-700 border border-amber-100',
                            };
                            $dot = match($p->status) {
                                'disetujui' => 'bg-green-500',
                                'ditolak'   => 'bg-red-400',
                                default     => 'bg-amber-500',
                            };
                            $label = match($p->status) {
                                'disetujui' => 'Disetujui',
                                'ditolak'   => 'Ditolak',
                                default     => 'Menunggu',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full {{ $badge }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                            {{ $label }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-4 text-center">
                        <button onclick="openModal(this)"
                            data-id="{{ $p->id }}"
                            data-no="{{ $p->no_peminjaman }}"
                            data-nama="{{ $pemohon->nama_lengkap ?? '-' }}"
                            data-nim="{{ $pemohon->nomor_induk ?? '-' }}"
                            data-email="{{ $pemohon->email ?? '-' }}"
                            data-ruangan="{{ $p->ruangan->nama_ruang }}"
                            data-gedung="{{ $p->ruangan->gedung->nama }}"
                            data-lantai="{{ $p->ruangan->lantai }}"
                            data-kampus="{{ $p->ruangan->gedung->kampus->nama_kampus ?? '' }}"
                            data-tanggal-mulai="{{ \Carbon\Carbon::parse($p->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}"
                            data-tanggal-selesai="{{ \Carbon\Carbon::parse($p->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}"
                            data-tanggal-sama="{{ $p->tanggal_mulai === $p->tanggal_selesai ? '1' : '0' }}"
                            data-waktu-mulai="{{ \Carbon\Carbon::parse($p->waktu_mulai)->format('H:i') }}"
                            data-waktu-selesai="{{ \Carbon\Carbon::parse($p->waktu_selesai)->format('H:i') }}"
                            data-kegiatan="{{ $p->kegiatan }}"
                            data-dokumen="{{ $p->dokumen_bukti ? asset('storage/'.$p->dokumen_bukti) : '' }}"
                            data-status="{{ $p->status }}"
                            data-catatan="{{ $p->catatan ?? '' }}"
                            data-approve-url="{{ route('sarpras.peminjaman.approve', $p->id) }}"
                            data-reject-url="{{ route('sarpras.peminjaman.reject', $p->id) }}"
                            data-semua-langkah="{{ $p->verifikasi->map(fn($v) => [
                                'urutan'            => $v->urutan,
                                'role_verifikator'  => $v->role_verifikator,
                                'status_verifikasi' => $v->status_verifikasi,
                                'waktu_verifikasi'  => $v->waktu_verifikasi
                                    ? \Carbon\Carbon::parse($v->waktu_verifikasi)->locale('id')->translatedFormat('d M Y, H:i')
                                    : null,
                                'catatan'           => $v->catatan,
                            ])->toJson() }}"
                            class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-500 hover:bg-blue-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-500 text-sm">Tidak ada data pengajuan</p>
                                <p class="text-xs text-slate-400 mt-0.5">Coba ubah filter pencarian Anda.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($peminjaman->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/40">
            {{ $peminjaman->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
</div>


{{-- ================================================================ --}}
{{-- MODAL DETAIL                                                      --}}
{{-- ================================================================ --}}
<div id="detailModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4"
    onclick="handleBackdrop(event)">

    <div id="modalPanel"
        class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all duration-200 scale-95 opacity-0">

        {{-- Modal Header --}}
        <div class="flex items-start justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Detail Pengajuan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Informasi lengkap peminjaman ruangan</p>
            </div>
            <div class="flex items-center gap-2">
                <span id="modal_status_badge" class="px-3 py-1 text-xs font-bold rounded-full"></span>
                <button onclick="closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="overflow-y-auto max-h-[65vh]">

            {{-- No Peminjaman --}}
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">No. Peminjaman</span>
                <span id="modal_no" class="font-mono text-sm font-bold text-slate-700 bg-white border border-slate-200 px-3 py-1 rounded-lg"></span>
            </div>

            <div class="px-6 py-5 space-y-6">

                {{-- DATA PEMOHON --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-blue-400"></i> Data Pemohon
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-200">
                            <div id="modal_avatar"
                                class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            </div>
                            <div>
                                <p id="modal_nama" class="font-bold text-slate-800 text-sm"></p>
                                <p id="modal_nim" class="text-xs text-slate-400 mt-0.5"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Email</p>
                                <p id="modal_email" class="font-semibold text-slate-700 text-xs"></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Jenis Pemohon</p>
                                <p class="font-semibold text-slate-700 text-xs">Organisasi Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DETAIL RUANGAN --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-door-open text-blue-400"></i> Detail Ruangan
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Ruangan</p>
                            <p id="modal_ruangan" class="font-bold text-slate-800"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Gedung / Lantai</p>
                            <p id="modal_gedung" class="font-semibold text-slate-700"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Kampus</p>
                            <p id="modal_kampus" class="font-semibold text-slate-700"></p>
                        </div>
                    </div>
                </div>

                {{-- JADWAL --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar text-blue-400"></i> Jadwal Peminjaman
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Tanggal</p>
                            <p id="modal_tanggal" class="font-bold text-slate-800"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Waktu</p>
                            <p id="modal_waktu" class="font-bold text-slate-800"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-slate-400 mb-0.5">Kegiatan</p>
                            <p id="modal_kegiatan" class="font-semibold text-slate-700 leading-relaxed"></p>
                        </div>
                    </div>
                </div>

                {{-- DOKUMEN --}}
                <div id="dokumenWrap">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-paperclip text-blue-400"></i> Dokumen Pendukung
                    </p>
                    <a id="modal_dokumen" href="#" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold rounded-xl hover:bg-blue-100 transition-colors">
                        <i class="fa-solid fa-file-arrow-down text-sm"></i>
                        Lihat / Unduh Dokumen
                    </a>
                </div>

                {{-- CATATAN (jika ada) --}}
                <div id="catatanWrap" class="hidden">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-note-sticky text-amber-400"></i> Catatan Verifikator
                    </p>
                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-sm text-amber-800">
                        <p id="modal_catatan"></p>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-blue-400"></i> Alur Verifikasi
                    </p>
                    <div id="modal_alur" class="space-y-2"></div>
                </div>

            </div>
        </div>

        {{-- Modal Footer --}}
        <div id="modalFooter" class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between gap-3 rounded-b-2xl">

            {{-- Form Tolak --}}
            <form id="formTolak" method="POST" class="flex items-center gap-2 flex-1">
                @csrf
                @method('PATCH')
                <input type="text" name="catatan" id="inputCatatan"
                    placeholder="Alasan penolakan (opsional)..."
                    class="flex-1 px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-300 transition bg-white text-slate-700">
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 rounded-xl transition-colors whitespace-nowrap">
                    <i class="fa-solid fa-xmark text-xs"></i>
                    Tolak
                </button>
            </form>

            {{-- Form Setujui --}}
            <form id="formSetujui" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-5 py-2 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 active:scale-95 rounded-xl transition-all shadow-sm shadow-green-200 whitespace-nowrap">
                    <i class="fa-solid fa-check text-xs"></i>
                    Setujui
                </button>
            </form>

        </div>

        {{-- Footer untuk status sudah diproses --}}
        <div id="modalFooterDone" class="hidden px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end rounded-b-2xl">
            <button onclick="closeModal()"
                class="px-5 py-2 text-sm font-semibold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-100 transition-colors">
                Tutup
            </button>
        </div>

    </div>
</div>

@push('js')
<script>
    const modal      = document.getElementById('detailModal');
    const modalPanel = document.getElementById('modalPanel');

    function openModal(btn) {
        const d = btn.dataset;

        // No & Avatar
        document.getElementById('modal_no').textContent      = d.no;
        document.getElementById('modal_avatar').textContent  = (d.nama || '?')[0].toUpperCase();
        document.getElementById('modal_nama').textContent    = d.nama;
        document.getElementById('modal_nim').textContent     = d.nim;
        document.getElementById('modal_email').textContent   = d.email;

        // Ruangan
        document.getElementById('modal_ruangan').textContent = d.ruangan;
        document.getElementById('modal_gedung').textContent  = `${d.gedung} · Lt.${d.lantai}`;
        document.getElementById('modal_kampus').textContent  = d.kampus || '—';

        // Jadwal
        const tanggal = d.tanggalSama === '1'
            ? d.tanggalMulai
            : `${d.tanggalMulai} – ${d.tanggalSelesai}`;
        document.getElementById('modal_tanggal').textContent = tanggal;
        document.getElementById('modal_waktu').textContent   = `${d.waktuMulai} – ${d.waktuSelesai}`;
        document.getElementById('modal_kegiatan').textContent = d.kegiatan;

        // Dokumen
        const dokWrap = document.getElementById('dokumenWrap');
        const dokLink = document.getElementById('modal_dokumen');
        if (d.dokumen) {
            dokLink.href = d.dokumen;
            dokWrap.classList.remove('hidden');
        } else {
            dokWrap.classList.add('hidden');
        }

        // Catatan
        const catatanWrap = document.getElementById('catatanWrap');
        const catatanEl   = document.getElementById('modal_catatan');
        if (d.catatan) {
            catatanEl.textContent = d.catatan;
            catatanWrap.classList.remove('hidden');
        } else {
            catatanWrap.classList.add('hidden');
        }

        // Status badge
        const badge = document.getElementById('modal_status_badge');
        const statusMap = {
            pending:   { cls: 'bg-amber-50 text-amber-700 border border-amber-100', label: 'Menunggu' },
            disetujui: { cls: 'bg-green-50 text-green-700 border border-green-100', label: 'Disetujui' },
            ditolak:   { cls: 'bg-red-50 text-red-600 border border-red-100',       label: 'Ditolak' },
        };
        const s = statusMap[d.status] || statusMap.pending;
        badge.className = `px-3 py-1 text-xs font-bold rounded-full ${s.cls}`;
        badge.textContent = s.label;

        const alurEl = document.getElementById('modal_alur');
        alurEl.innerHTML = '';

        let langkah = [];
        try { langkah = JSON.parse(d.semuaLangkah || '[]'); } catch(e) {}

        langkah.forEach((v, i) => {
            const stepStatus = v.status_verifikasi;
            const warna = stepStatus === 'disetujui'
                ? { ring: 'border-green-200 bg-green-50', dot: 'bg-green-500', text: 'text-green-700', badge: 'bg-green-50 text-green-700 border border-green-100', label: 'Disetujui' }
                : stepStatus === 'ditolak'
                ? { ring: 'border-red-200 bg-red-50',   dot: 'bg-red-400',   text: 'text-red-600',   badge: 'bg-red-50 text-red-600 border border-red-100',     label: 'Ditolak' }
                : { ring: 'border-slate-200 bg-slate-50', dot: 'bg-amber-400', text: 'text-amber-700', badge: 'bg-amber-50 text-amber-700 border border-amber-100', label: 'Pending' };

            const catatan = v.catatan
                ? `<p class="text-xs text-slate-500 mt-1 italic">"${v.catatan}"</p>`
                : '';

            const waktu = v.waktu_verifikasi
                ? `<p class="text-xs text-slate-400 mt-0.5">${v.waktu_verifikasi}</p>`
                : '';

            alurEl.innerHTML += `
                <div class="flex items-start gap-3 border ${warna.ring} rounded-xl px-4 py-3">
                    <div class="flex flex-col items-center gap-1 flex-shrink-0 mt-0.5">
                        <span class="w-6 h-6 rounded-full border-2 border-white shadow flex items-center justify-center text-[10px] font-extrabold text-white ${warna.dot}">
                            ${v.urutan}
                        </span>
                        ${i < langkah.length - 1 ? '<div class="w-px h-3 bg-slate-200"></div>' : ''}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-semibold text-slate-700 capitalize">${v.role_verifikator}</p>
                            <span class="px-2 py-0.5 text-[11px] font-bold rounded-full ${warna.badge}">${warna.label}</span>
                        </div>
                        ${waktu}
                        ${catatan}
                    </div>
                </div>
            `;
        });

        if (!langkah.length) {
            alurEl.innerHTML = '<p class="text-xs text-slate-400">Belum ada data verifikasi.</p>';
        }

        // Footer: tampilkan aksi hanya jika pending
        const footerAction = document.getElementById('modalFooter');
        const footerDone   = document.getElementById('modalFooterDone');
        if (d.status === 'pending') {
            document.getElementById('formSetujui').action = d.approveUrl;
            document.getElementById('formTolak').action   = d.rejectUrl;
            footerAction.classList.remove('hidden');
            footerDone.classList.add('hidden');
        } else {
            footerAction.classList.add('hidden');
            footerDone.classList.remove('hidden');
        }

        // Buka modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(() => {
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeModal() {
        modalPanel.classList.add('scale-95', 'opacity-0');
        modalPanel.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    function handleBackdrop(e) {
        if (e.target === modal) closeModal();
    }
</script>
@endpush

</x-master>