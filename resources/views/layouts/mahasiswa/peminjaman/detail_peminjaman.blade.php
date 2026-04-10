<x-master>
<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="mb-7 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Detail Pengajuan
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Informasi lengkap pengajuan peminjaman
            </p>
        </div>

        @php
            $statusColor = [
                'pending'   => 'bg-yellow-100 text-yellow-700',
                'disetujui' => 'bg-green-100 text-green-700',
                'ditolak'   => 'bg-red-100 text-red-700',
            ];
        @endphp

        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $statusColor[$peminjaman->status] }}">
            {{ ucfirst($peminjaman->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-5 items-start">

        <!-- KOLOM KIRI -->
        <div class="space-y-4">

            <!-- SECTION 1: LOKASI -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">1</span>
                    Lokasi Ruangan
                </p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 mb-1">Ruangan</p>
                        <p class="font-semibold text-slate-700">
                            {{ $peminjaman->ruangan->nomor_ruang }} - {{ $peminjaman->ruangan->nama_ruang }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Gedung</p>
                        <p class="text-slate-600">{{ $peminjaman->ruangan->gedung->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: WAKTU -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">2</span>
                    Waktu Peminjaman
                </p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 mb-1">Tanggal</p>
                        <p class="text-slate-600">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->translatedFormat('d F Y') }}
                            –
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Waktu</p>
                        <p class="text-slate-600">{{ $peminjaman->waktu_mulai }} – {{ $peminjaman->waktu_selesai }}</p>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: DETAIL KEGIATAN -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">3</span>
                    Detail Kegiatan
                </p>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-400 mb-1">No Peminjaman</p>
                        <p class="font-semibold text-slate-700">{{ $peminjaman->no_peminjaman }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Kegiatan</p>
                        <p class="text-slate-600">{{ $peminjaman->kegiatan }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Waktu Pengajuan</p>
                        <p class="text-slate-600">
                            {{ \Carbon\Carbon::parse($peminjaman->created_at)->translatedFormat('d F Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Dokumen</p>
                        @if($peminjaman->dokumen_bukti)
                            <a href="{{ asset('storage/'.$peminjaman->dokumen_bukti) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-sm text-blue-500 hover:underline">
                                <i class="fa-solid fa-file text-xs"></i>
                                Lihat Dokumen
                            </a>
                        @else
                            <p class="text-slate-400">Tidak ada dokumen</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TIMELINE: ALUR VERIFIKASI HORIZONTAL -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px]">
                        <i class="fa-regular fa-clock"></i>
                    </span>
                    Alur Verifikasi
                </p>

                <div class="relative flex items-start">

                    {{-- Garis horizontal penghubung --}}
                    <div class="absolute top-4 left-0 right-0 h-px bg-slate-200 z-0"></div>

                    {{-- STEP AWAL --}}
                    <div class="relative z-10 flex flex-col items-center text-center flex-1">
                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">✓</div>
                        <p class="text-xs font-semibold text-slate-700 mt-3">Pengajuan</p>
                        <p class="text-[11px] text-slate-400">dibuat</p>
                        <p class="text-[10px] text-blue-500 mt-1">
                            {{ \Carbon\Carbon::parse($peminjaman->created_at)->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-[10px] text-blue-500">
                            {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('H:i') }}
                        </p>
                    </div>

                    {{-- LOOP ALUR --}}
                    @foreach($alur as $step)
                        @php
                            $verif     = $riwayat->firstWhere('urutan', $step->urutan);
                            $status    = $verif->status_verifikasi ?? null;
                            $isDone    = $status === 'disetujui';
                            $isReject  = $status === 'ditolak';
                        @endphp

                        <div class="relative z-10 flex flex-col items-center text-center flex-1">
                            @if($isDone)
                                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">✓</div>
                            @elseif($isReject)
                                <div class="w-8 h-8 rounded-full bg-red-400 text-white flex items-center justify-center text-xs font-bold shadow-sm">✕</div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-amber-400 text-white flex items-center justify-center text-sm font-black shadow-sm">•</div>
                            @endif

                            <p class="text-xs font-semibold text-slate-700 mt-3 capitalize">{{ $step->role_verifikator }}</p>

                            @if($isDone)
                                <span class="text-[10px] px-2 py-0.5 bg-green-50 text-green-700 rounded-full mt-1">Disetujui</span>
                            @elseif($isReject)
                                <span class="text-[10px] px-2 py-0.5 bg-red-50 text-red-600 rounded-full mt-1">Ditolak</span>
                            @else
                                <span class="text-[10px] px-2 py-0.5 bg-amber-50 text-amber-700 rounded-full mt-1">Menunggu</span>
                            @endif

                            @if($verif && $verif->waktu_verifikasi)
                                <p class="text-[10px] text-slate-400 mt-1">
                                    {{ \Carbon\Carbon::parse($verif->waktu_verifikasi)->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-[10px] text-slate-400">
                                    {{ \Carbon\Carbon::parse($verif->waktu_verifikasi)->format('H:i') }}
                                </p>
                            @endif

                            @if($verif && $verif->catatan)
                                <p class="text-[10px] text-slate-500 italic mt-1 max-w-[80px]">"{{ Str::limit($verif->catatan, 30) }}"</p>
                            @endif
                        </div>
                    @endforeach

                    {{-- FINAL: Selesai --}}
                    <div class="relative z-10 flex flex-col items-center text-center flex-1">
                        @if($peminjaman->status === 'disetujui')
                            <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold shadow-sm">✓</div>
                        @elseif($peminjaman->status === 'ditolak')
                            <div class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">✕</div>
                        @else
                            <div class="w-8 h-8 rounded-full bg-slate-200"></div>
                        @endif
                        <p class="text-xs font-semibold text-slate-700 mt-3">Selesai</p>
                        <p class="text-[10px] text-slate-400">Status akhir</p>
                    </div>

                </div>
            </div>

        </div>
        {{-- TUTUP KOLOM KIRI --}}

        <!-- SIDEBAR -->
        <div class="lg:sticky lg:top-6">
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-sm font-bold text-slate-700">Ringkasan Pengajuan</p>
                </div>

                <div class="px-5 py-4 space-y-3 text-sm">
                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Ruangan</span>
                        <span class="font-semibold text-slate-700 text-right">
                            {{ $peminjaman->ruangan->nomor_ruang }} - {{ $peminjaman->ruangan->nama_ruang }}
                        </span>
                    </div>
                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Gedung</span>
                        <span class="text-slate-600 text-right">{{ $peminjaman->ruangan->gedung->nama }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Tanggal</span>
                        <span class="text-slate-600 text-right">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-slate-400 shrink-0">Waktu</span>
                        <span class="text-slate-600">{{ $peminjaman->waktu_mulai }} – {{ $peminjaman->waktu_selesai }}</span>
                    </div>
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-slate-400 shrink-0">Status</span>
                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full {{ $statusColor[$peminjaman->status] }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                </div>

                <div class="px-5 pb-3">
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2.5">
                        <i class="fa-solid fa-circle-info text-blue-400 text-xs mt-0.5 shrink-0"></i>
                        <span class="text-xs text-blue-700">No. {{ $peminjaman->no_peminjaman }}</span>
                    </div>
                </div>

                <div class="px-5 pb-5">
                    <a href="{{ route('mahasiswa.list-peminjaman') }}"
                       class="w-full flex items-center justify-center gap-2 py-2.5 border border-slate-200 text-slate-600 font-semibold text-sm rounded-xl hover:bg-slate-50 transition-colors">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
        {{-- TUTUP SIDEBAR --}}

    </div>
    {{-- TUTUP GRID --}}

</div>
</div>
</x-master>
