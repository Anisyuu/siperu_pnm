<x-master>
<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="mb-7 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Detail Jadwal
            </h1>
            <p class="mt-0.5 text-sm text-slate-500">
                Informasi lengkap mengenai jadwal penggunaan ruangan
            </p>
        </div>
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
                        <p class="text-slate-400 mb-1">Kampus</p>
                        <p class="text-slate-600">
                            {{ $jadwal->ruangan->gedung->kampus->nama_kampus ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400 mb-1">Gedung</p>
                        <p class="text-slate-600">
                            {{ $jadwal->ruangan->gedung->nama ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Lantai</p>
                        <p class="text-slate-600">
                            Lantai {{ $jadwal->ruangan->lantai ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Ruangan</p>
                        <p class="text-slate-600">
                            {{ $jadwal->ruangan->nama_ruang ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Jenis Ruangan</p>
                        <p class="text-slate-600">
                            {{ $jadwal->ruangan->jenisRuangan->nama ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: WAKTU -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-extrabold">2</span>
                    Waktu Jadwal
                </p>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 mb-1">Tanggal</p>
                        <p class="text-slate-600">
                            {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->translatedFormat('d F Y') }}
                            –
                            {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Waktu</p>
                        <p class="text-slate-600">
                            {{ substr($jadwal->waktu_mulai, 0, 5) }}
                            –
                            {{ substr($jadwal->waktu_selesai, 0, 5) }}
                        </p>
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
                        <p class="text-slate-400 mb-1">Kegiatan</p>
                        <p class="text-slate-600">
                            {{ $jadwal->kegiatan ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Penanggung Jawab</p>
                        <p class="text-slate-600">
                            {{ $jadwal->penanggung_jawab ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Waktu Dibuat</p>
                        <p class="text-slate-600">
                            {{ $jadwal->created_at ? \Carbon\Carbon::parse($jadwal->created_at)->translatedFormat('d F Y H:i') : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 mb-1">Catatan</p>
                        <p class="text-slate-600">
                            {{ $jadwal->catatan ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
        {{-- TUTUP KOLOM KIRI --}}

        <!-- SIDEBAR -->
        <div class="lg:sticky lg:top-6">
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-sm font-bold text-slate-700">
                        Ringkasan Jadwal
                    </p>
                </div>

                <div class="px-5 py-4 space-y-3 text-sm">
                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Ruangan</span>
                        <span class="font-semibold text-slate-700 text-right">
                            {{ $jadwal->ruangan->nama_ruang ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Gedung</span>
                        <span class="text-slate-600 text-right">
                            {{ $jadwal->ruangan->gedung->nama ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-start gap-4">
                        <span class="text-slate-400 shrink-0">Tanggal</span>
                        <span class="text-slate-600 text-right">
                            {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center gap-4">
                        <span class="text-slate-400 shrink-0">Waktu</span>
                        <span class="text-slate-600">
                            {{ substr($jadwal->waktu_mulai, 0, 5) }}
                            –
                            {{ substr($jadwal->waktu_selesai, 0, 5) }}
                        </span>
                    </div>
                </div>

                <div class="px-5 pb-3">
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2.5">
                        <i class="fa-solid fa-circle-info text-blue-400 text-xs mt-0.5 shrink-0"></i>
                        <span class="text-xs text-blue-700">
                            {{ $jadwal->kegiatan ?? 'Jadwal penggunaan ruangan' }}
                        </span>
                    </div>
                </div>

                <div class="px-5 pb-5 flex flex-col gap-2">
                    <a href="{{ url()->previous() }}"
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
