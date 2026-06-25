<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Riwayat Verifikasi</h1>
            <p class="text-slate-500 text-sm mt-1">Riwayat seluruh pengajuan yang telah Anda verifikasi</p>
        </div>
        <a href="{{ route('pimpinan.riwayat-verifikasi.export', request()->query()) }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
            <i class="fa-solid fa-file-csv text-blue-500"></i>
            Unduh CSV
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <div class="flex flex-col md:flex-row gap-3">

            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kegiatan, pemohon, atau nomor peminjaman..."
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

            @if(request()->hasAny(['search', 'status']))
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
                        <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No.</th>
                        <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No. Peminjaman</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pemohon</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ruangan</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Kegiatan</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Langkah Verifikasi</th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Akhir</th>
                        <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">

                @forelse($peminjaman as $p)
                @php
                    $pemohon = $p->pemohon;
                    $userId  = auth()->user()->nomor_induk;

                    // Ambil langkah verifikasi yang dikerjakan oleh user ini
                    $langkahSaya = $p->verifikasi
                        ->where('id_verifikator', $userId)
                        ->sortBy('urutan')
                        ->first();

                    // Total langkah dalam peminjaman ini
                    $totalLangkah = $p->verifikasi->count();
                @endphp
                <tr class="hover:bg-slate-50/70 transition-colors group">

                    {{-- No. --}}
                    <td class="px-5 py-4 text-sm text-slate-600 whitespace-nowrap">
                        {{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}
                    </td>

                    {{-- No Peminjaman --}}
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">
                            {{ $p->no_peminjaman }}
                        </span>
                    </td>

                    {{-- Pemohon --}}
                    <td class="px-4 py-4">
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

                    {{-- Tanggal Kegiatan --}}
                    <td class="px-4 py-4 text-sm text-slate-600">
                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->locale('id')->translatedFormat('d M Y') }}
                        @if($p->tanggal_mulai !== $p->tanggal_selesai)
                            <div class="text-xs text-slate-400">
                                s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->locale('id')->translatedFormat('d M Y') }}
                            </div>
                        @endif
                    </td>

                    {{-- Langkah Verifikasi saya --}}
                    <td class="px-4 py-4">
                        @if($langkahSaya)
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs text-slate-500">Urutan {{ $langkahSaya->urutan }}/{{ $totalLangkah }}</span>
                            @php
                                $stepDot = match($langkahSaya->status_verifikasi) {
                                    'disetujui' => 'bg-green-500',
                                    'ditolak'   => 'bg-red-400',
                                    default     => 'bg-amber-400',
                                };
                                $stepLabel = match($langkahSaya->status_verifikasi) {
                                    'disetujui' => 'Disetujui',
                                    'ditolak'   => 'Ditolak',
                                    default     => 'Pending',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-bold rounded-full
                                {{ $langkahSaya->status_verifikasi === 'disetujui' ? 'bg-green-50 text-green-700' : ($langkahSaya->status_verifikasi === 'ditolak' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-700') }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $stepDot }}"></span>
                                {{ $stepLabel }}
                            </span>
                        </div>
                        @if($langkahSaya->waktu_verifikasi)
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($langkahSaya->waktu_verifikasi)->locale('id')->translatedFormat('d M Y, H:i') }}
                        </p>
                        @endif
                        @else
                        <span class="text-xs text-slate-400">—</span>
                        @endif
                    </td>

                    {{-- Status Akhir Peminjaman --}}
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
                            data-no="{{ $p->no_peminjaman }}"
                            data-diajukan="{{ \Carbon\Carbon::parse($p->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}"

                            data-pemohon="{{ $pemohon->nama_lengkap ?? '-' }}"
                            data-nim="{{ $pemohon->nomor_induk ?? '-' }}"
                            data-email="{{ $pemohon->email ?? '-' }}"
                            data-jenis-pemohon="{{ $pemohon?->roles?->pluck('nama')->join(', ') ?: '-' }}"

                            data-ruangan="{{ $p->ruangan->nama_ruang }}"
                            data-gedung="{{ $p->ruangan->gedung->nama }}"
                            data-lantai="{{ $p->ruangan->lantai }}"
                            data-kampus="{{ $p->ruangan->gedung->kampus->nama_kampus ?? '-' }}"

                            data-tanggal="{{ \Carbon\Carbon::parse($p->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}{{ $p->tanggal_mulai !== $p->tanggal_selesai ? ' s/d '.\Carbon\Carbon::parse($p->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : '' }}"
                            data-waktu="{{ \Carbon\Carbon::parse($p->waktu_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($p->waktu_selesai)->format('H:i') }}"
                            data-kegiatan="{{ $p->kegiatan }}"
                            data-dokumen="{{ $p->dokumen_bukti ? asset('storage/'.$p->dokumen_bukti) : '' }}"

                            data-status="{{ $p->status }}"

                            data-urutan="{{ $langkahSaya?->urutan ?? '-' }}"
                            data-total-urutan="{{ $totalLangkah }}"
                            data-role-verifikator="{{ $langkahSaya?->role_verifikator ?? '-' }}"
                            data-status-langkah="{{ $langkahSaya?->status_verifikasi ?? '-' }}"
                            data-waktu-verifikasi="{{ $langkahSaya?->waktu_verifikasi ? \Carbon\Carbon::parse($langkahSaya->waktu_verifikasi)->locale('id')->translatedFormat('d F Y, H:i') : '-' }}"
                            data-catatan="{{ $langkahSaya?->catatan ?? '' }}"

                            data-semua-langkah="{{ $p->verifikasi->map(fn($v) => [
                                'urutan'                  => $v->urutan,
                                'role_verifikator'        => $v->role_verifikator,
                                'nama_verifikator'        => $v->verifikator->nama_lengkap ?? null,
                                'nomor_induk_verifikator' => $v->verifikator->nomor_induk ?? null,
                                'status_verifikasi'       => $v->status_verifikasi,
                                'waktu_verifikasi'        => $v->waktu_verifikasi
                                    ? \Carbon\Carbon::parse($v->waktu_verifikasi)->locale('id')->translatedFormat('d M Y, H:i')
                                    : null,
                                'catatan'                 => $v->catatan,
                            ])->toJson() }}"

                            class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-500 hover:bg-blue-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-500 text-sm">Belum ada riwayat verifikasi</p>
                                <p class="text-xs text-slate-400 mt-0.5">Riwayat akan muncul setelah Anda memverifikasi pengajuan.</p>
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
{{-- MODAL DETAIL RIWAYAT                                             --}}
{{-- ================================================================ --}}
<div id="detailModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4"
    onclick="handleBackdrop(event)">

    <div id="modalPanel"
        class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all duration-200 scale-95 opacity-0">

        {{-- Header --}}
        <div class="flex items-start justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Detail Riwayat Verifikasi</h3>
                <p class="text-xs text-slate-400 mt-0.5">Informasi lengkap riwayat verifikasi peminjaman</p>
            </div>

            <div class="flex items-center gap-2">
                <span id="modal_status_badge" class="px-3 py-1 text-xs font-bold rounded-full"></span>

                <button onclick="closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto max-h-[70vh]">

            {{-- RINGKASAN --}}
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">No. Peminjaman</p>
                    <span id="modal_no"
                        class="inline-flex font-mono text-sm font-bold text-slate-700 bg-white border border-slate-200 px-3 py-1 rounded-lg">
                    </span>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Diajukan</p>
                    <p id="modal_diajukan" class="text-sm font-semibold text-slate-700"></p>
                </div>
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
                                <p id="modal_pemohon" class="font-bold text-slate-800 text-sm"></p>
                                <p id="modal_nim" class="text-xs text-slate-400 mt-0.5"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Email</p>
                                <p id="modal_email" class="font-semibold text-slate-700 text-xs"></p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Jenis Pemohon</p>
                                <p id="modal_jenis_pemohon" class="font-semibold text-slate-700 text-xs"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DETAIL RUANGAN --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-door-open text-blue-400"></i> Detail Ruangan
                    </p>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
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

                {{-- JADWAL PEMINJAMAN --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar text-blue-400"></i> Jadwal Peminjaman
                    </p>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Tanggal Kegiatan</p>
                            <p id="modal_tanggal" class="font-bold text-slate-800"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Waktu</p>
                            <p id="modal_waktu" class="font-bold text-slate-800"></p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-xs text-slate-400 mb-0.5">Kegiatan</p>
                            <p id="modal_kegiatan" class="font-semibold text-slate-700 leading-relaxed"></p>
                        </div>
                    </div>
                </div>

                {{-- DETAIL VERIFIKASI SAYA --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-check text-blue-400"></i> Verifikasi Saya
                    </p>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Langkah Verifikasi</p>
                            <p id="modal_langkah_saya" class="font-bold text-slate-800"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Role Verifikator</p>
                            <p id="modal_role_verifikator" class="font-semibold text-slate-700 capitalize"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Status Verifikasi</p>
                            <span id="modal_status_langkah_badge" class="inline-flex px-2.5 py-1 text-xs font-bold rounded-full"></span>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Waktu Verifikasi</p>
                            <p id="modal_waktu_verifikasi" class="font-semibold text-slate-700"></p>
                        </div>
                    </div>
                </div>

                {{-- CATATAN SAYA --}}
                <div id="catatanWrap" class="hidden">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-note-sticky text-amber-400"></i> Catatan Verifikasi Saya
                    </p>

                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-sm text-amber-800">
                        <p id="modal_catatan"></p>
                    </div>
                </div>

                {{-- DOKUMEN --}}
                <div id="dokumenWrap" class="hidden">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-paperclip text-blue-400"></i> Dokumen Pendukung
                    </p>

                    <a id="modal_dokumen" href="#" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold rounded-xl hover:bg-blue-100 transition-colors">
                        <i class="fa-solid fa-file-arrow-down text-sm"></i>
                        Lihat / Unduh Dokumen
                    </a>
                </div>

                {{-- ALUR VERIFIKASI --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-blue-400"></i> Alur Verifikasi Lengkap
                    </p>

                    <div id="modal_alur" class="space-y-2"></div>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end rounded-b-2xl">
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

    function setBadge(element, status) {
        const statusMap = {
            pending:   { cls: 'bg-amber-50 text-amber-700 border border-amber-100', label: 'Menunggu' },
            disetujui: { cls: 'bg-green-50 text-green-700 border border-green-100', label: 'Disetujui' },
            ditolak:   { cls: 'bg-red-50 text-red-600 border border-red-100',       label: 'Ditolak' },
            '-':        { cls: 'bg-slate-50 text-slate-500 border border-slate-100', label: '-' },
        };

        const s = statusMap[status] || statusMap['-'];

        element.className = `inline-flex px-2.5 py-1 text-xs font-bold rounded-full ${s.cls}`;
        element.textContent = s.label;
    }

    function openModal(btn) {
        const d = btn.dataset;

        // Ringkasan
        document.getElementById('modal_no').textContent = d.no || '—';
        document.getElementById('modal_diajukan').textContent = d.diajukan || '—';

        // Data Pemohon
        document.getElementById('modal_avatar').textContent = (d.pemohon || '?')[0].toUpperCase();
        document.getElementById('modal_pemohon').textContent = d.pemohon || '—';
        document.getElementById('modal_nim').textContent = d.nim || '—';
        document.getElementById('modal_email').textContent = d.email || '—';
        document.getElementById('modal_jenis_pemohon').textContent = d.jenisPemohon || '—';

        // Detail Ruangan
        document.getElementById('modal_ruangan').textContent = d.ruangan || '—';
        document.getElementById('modal_gedung').textContent = `${d.gedung || '—'} · Lt.${d.lantai || '-'}`;
        document.getElementById('modal_kampus').textContent = d.kampus || '—';

        // Jadwal
        document.getElementById('modal_tanggal').textContent = d.tanggal || '—';
        document.getElementById('modal_waktu').textContent = d.waktu || '—';
        document.getElementById('modal_kegiatan').textContent = d.kegiatan || '—';

        // Status Akhir
        const badgeAkhir = document.getElementById('modal_status_badge');
        setBadge(badgeAkhir, d.status);

        // Verifikasi Saya
        document.getElementById('modal_langkah_saya').textContent =
            d.urutan && d.totalUrutan
                ? `Urutan ${d.urutan}/${d.totalUrutan}`
                : '—';

        document.getElementById('modal_role_verifikator').textContent = d.roleVerifikator || '—';
        document.getElementById('modal_waktu_verifikasi').textContent = d.waktuVerifikasi || '—';

        const badgeLangkah = document.getElementById('modal_status_langkah_badge');
        setBadge(badgeLangkah, d.statusLangkah);

        // Catatan Saya
        const catatanWrap = document.getElementById('catatanWrap');
        const catatanEl = document.getElementById('modal_catatan');

        if (d.catatan && d.catatan.trim() !== '') {
            catatanEl.textContent = d.catatan;
            catatanWrap.classList.remove('hidden');
        } else {
            catatanWrap.classList.add('hidden');
        }

        // Dokumen
        const dokWrap = document.getElementById('dokumenWrap');
        const dokLink = document.getElementById('modal_dokumen');

        if (d.dokumen && d.dokumen.trim() !== '') {
            dokLink.href = d.dokumen;
            dokWrap.classList.remove('hidden');
        } else {
            dokWrap.classList.add('hidden');
        }

        // Alur Verifikasi Lengkap
        const alurEl = document.getElementById('modal_alur');
        alurEl.innerHTML = '';

        let langkah = [];

        try {
            langkah = JSON.parse(d.semuaLangkah || '[]');
        } catch(e) {
            langkah = [];
        }

        langkah.forEach((v, i) => {
            const stepStatus = v.status_verifikasi;

            const warna = stepStatus === 'disetujui'
                ? {
                    ring: 'border-green-200 bg-green-50',
                    dot: 'bg-green-500',
                    badge: 'bg-green-50 text-green-700 border border-green-100',
                    label: 'Disetujui'
                }
                : stepStatus === 'ditolak'
                ? {
                    ring: 'border-red-200 bg-red-50',
                    dot: 'bg-red-400',
                    badge: 'bg-red-50 text-red-600 border border-red-100',
                    label: 'Ditolak'
                }
                : {
                    ring: 'border-slate-200 bg-slate-50',
                    dot: 'bg-amber-400',
                    badge: 'bg-amber-50 text-amber-700 border border-amber-100',
                    label: 'Pending'
                };

            const waktu = v.waktu_verifikasi
                ? `<p class="text-xs text-slate-400 mt-0.5">${v.waktu_verifikasi}</p>`
                : `<p class="text-xs text-slate-400 mt-0.5">Belum diverifikasi</p>`;

            const catatan = v.catatan
                ? `<p class="text-xs text-slate-500 mt-1 italic">"${v.catatan}"</p>`
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
                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    ${v.nama_verifikator || v.role_verifikator || '—'}
                                </p>
                                <p class="text-xs text-slate-400 capitalize">
                                    ${v.nama_verifikator ? v.role_verifikator : 'Belum diverifikasi'}
                                </p>
                            </div>
                            <span class="px-2 py-0.5 text-[11px] font-bold rounded-full ${warna.badge}">
                                ${warna.label}
                            </span>
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

        // Buka Modal
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
