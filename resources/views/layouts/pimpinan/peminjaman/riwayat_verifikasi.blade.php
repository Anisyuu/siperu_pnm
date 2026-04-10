<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-slate-900 text-3xl font-extrabold tracking-tight">Riwayat Verifikasi</h2>
            <p class="text-slate-500 text-sm mt-1">Riwayat seluruh pengajuan yang telah Anda verifikasi</p>
        </div>
        <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
            <i class="fa-solid fa-file-export text-slate-400"></i>
            Ekspor Riwayat
        </button>
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
                            data-pemohon="{{ $pemohon->nama_lengkap ?? '-' }}"
                            data-nim="{{ $pemohon->nomor_induk ?? '-' }}"
                            data-ruangan="{{ $p->ruangan->nama_ruang }} — {{ $p->ruangan->gedung->nama }} Lt.{{ $p->ruangan->lantai }}"
                            data-tanggal="{{ \Carbon\Carbon::parse($p->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}{{ $p->tanggal_mulai !== $p->tanggal_selesai ? ' s/d '.\Carbon\Carbon::parse($p->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : '' }}"
                            data-waktu="{{ \Carbon\Carbon::parse($p->waktu_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($p->waktu_selesai)->format('H:i') }}"
                            data-kegiatan="{{ $p->kegiatan }}"
                            data-status="{{ $p->status }}"
                            data-urutan="{{ $langkahSaya?->urutan ?? '-' }}"
                            data-total-urutan="{{ $totalLangkah }}"
                            data-role-verifikator="{{ $langkahSaya?->role_verifikator ?? '-' }}"
                            data-status-langkah="{{ $langkahSaya?->status_verifikasi ?? '-' }}"
                            data-waktu-verifikasi="{{ $langkahSaya?->waktu_verifikasi ? \Carbon\Carbon::parse($langkahSaya->waktu_verifikasi)->locale('id')->translatedFormat('d F Y, H:i') : '-' }}"
                            data-catatan="{{ $langkahSaya?->catatan ?? '' }}"
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
                <p id="modal_no" class="text-xs text-slate-400 mt-0.5 font-mono"></p>
            </div>
            <button onclick="closeModal()"
                class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto max-h-[70vh]">
            <div class="px-6 py-5 space-y-5">

                {{-- INFO PEMOHON + RUANGAN --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 col-span-2">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-user text-blue-400"></i> Pemohon
                        </p>
                        <div class="flex items-center gap-3">
                            <div id="modal_avatar"
                                class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-extrabold flex-shrink-0"></div>
                            <div>
                                <p id="modal_pemohon" class="font-bold text-slate-800 text-sm"></p>
                                <p id="modal_nim" class="text-xs text-slate-400 mt-0.5"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-door-open text-blue-400"></i> Ruangan
                        </p>
                        <p id="modal_ruangan" class="text-sm font-semibold text-slate-700"></p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar text-blue-400"></i> Jadwal
                        </p>
                        <p id="modal_tanggal" class="text-sm font-semibold text-slate-700"></p>
                        <p id="modal_waktu" class="text-xs text-slate-400 mt-0.5"></p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 col-span-2">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kegiatan</p>
                        <p id="modal_kegiatan" class="text-sm text-slate-700 leading-relaxed"></p>
                    </div>
                </div>

                {{-- STATUS AKHIR --}}
                <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Akhir Peminjaman</span>
                    <span id="modal_status_badge" class="px-3 py-1 text-xs font-bold rounded-full"></span>
                </div>

                {{-- ALUR VERIFIKASI --}}
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-blue-400"></i> Alur Verifikasi
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

    function openModal(btn) {
        const d = btn.dataset;

        // Header
        document.getElementById('modal_no').textContent       = d.no;
        document.getElementById('modal_avatar').textContent   = (d.pemohon || '?')[0].toUpperCase();
        document.getElementById('modal_pemohon').textContent  = d.pemohon;
        document.getElementById('modal_nim').textContent      = d.nim;
        document.getElementById('modal_ruangan').textContent  = d.ruangan;
        document.getElementById('modal_tanggal').textContent  = d.tanggal;
        document.getElementById('modal_waktu').textContent    = d.waktu;
        document.getElementById('modal_kegiatan').textContent = d.kegiatan;

        // Status badge
        const badge    = document.getElementById('modal_status_badge');
        const statusMap = {
            pending:   { cls: 'bg-amber-50 text-amber-700 border border-amber-100', label: 'Menunggu' },
            disetujui: { cls: 'bg-green-50 text-green-700 border border-green-100', label: 'Disetujui' },
            ditolak:   { cls: 'bg-red-50 text-red-600 border border-red-100',       label: 'Ditolak' },
        };
        const s = statusMap[d.status] || statusMap.pending;
        badge.className   = `px-3 py-1 text-xs font-bold rounded-full ${s.cls}`;
        badge.textContent = s.label;

        // Alur verifikasi — render semua langkah
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
