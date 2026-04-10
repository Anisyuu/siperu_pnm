<x-master>

<div class="max-w-4xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm">

    <!-- Header -->
    <div class="flex items-start justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-text-main flex items-center gap-3">
                Detail Pengajuan
            </h2>

            <p class="text-sm text-text-secondary mt-1">
                Informasi lengkap pengajuan peminjaman ruangan
            </p>
        </div>

        <!-- Status -->
        <div>

            @if($peminjaman->status == 'pending')
                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700">
                    Pending
                </span>

            @elseif($peminjaman->status == 'disetujui')
                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700">
                    Disetujui
                </span>

            @else
                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-700">
                    Ditolak
                </span>
            @endif

        </div>
    </div>


    <!-- Informasi -->
    <div class="grid grid-cols-2 gap-6 mb-10">

        <div class="col-span-2">
            <label class="block text-sm font-semibold mb-2">No Peminjaman</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ $peminjaman->no_peminjaman }}
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-2">Waktu Pengajuan</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ \Carbon\Carbon::parse($peminjaman->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-2">Kegiatan</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ $peminjaman->kegiatan }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Ruangan</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ $peminjaman->ruangan->nama_ruang }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Gedung</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ $peminjaman->ruangan->gedung->nama }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Tanggal</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ \Carbon\Carbon::parse($peminjaman->tanggal)->locale('id')->translatedFormat('d F Y') }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Waktu</label>
            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
                {{ $peminjaman->waktu_mulai }} - {{ $peminjaman->waktu_selesai }}
            </div>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-semibold mb-2">Dokumen Bukti</label>

            <div class="px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">

                @if($peminjaman->dokumen_bukti)
                    <a href="{{ asset('storage/'.$peminjaman->dokumen_bukti) }}"
                       target="_blank"
                       class="flex items-center gap-2 text-primary hover:underline">

                        <i class="fa-regular fa-file"></i>
                        Lihat Dokumen

                    </a>
                @else
                    <span class="text-gray-400">Tidak ada dokumen</span>
                @endif

            </div>
        </div>

    </div>


    <!-- Timeline -->
<div class="mt-10 border border-gray-200 rounded-xl p-6 bg-gray-50">

    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
        <i class="fa-regular fa-clock"></i>
        Alur Verifikasi
    </h3>

    <div class="space-y-4">

        {{-- STEP AWAL --}}
        <div class="flex gap-3 items-start">
            <div class="flex flex-col items-center mt-1">
                <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold">
                    ✓
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-700">Pengajuan Dibuat</p>
                <p class="text-xs text-gray-500">
                    {{ \Carbon\Carbon::parse($peminjaman->created_at)->translatedFormat('d F Y H:i') }}
                </p>
            </div>
        </div>

        @php
            $currentStep = null;

            foreach ($alur as $s) {
                $cek = $riwayat->firstWhere('urutan', $s->urutan);
                if (!$cek) {
                    $currentStep = $s->urutan;
                    break;
                }
            }
        @endphp

        {{-- LOOP ALUR --}}
        @foreach($alur as $step)

            @php
                $verif = $riwayat->firstWhere('urutan', $step->urutan);

                $status = $verif->status_verifikasi ?? null;

                $isDone = $status === 'disetujui';
                $isReject = $status === 'ditolak';
                $isCurrent = $step->urutan == $currentStep;
            @endphp

            <div class="flex gap-3 items-start">

                {{-- DOT --}}
                <div class="flex flex-col items-center mt-1">

                    @if($isDone)
                        <div class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold">✓</div>
                    @elseif($isReject)
                        <div class="w-6 h-6 rounded-full bg-red-400 text-white flex items-center justify-center text-xs font-bold">✕</div>
                    @elseif(!$status)
                        <div class="w-6 h-6 rounded-full bg-amber-400 text-white flex items-center justify-center text-xs font-bold">•</div>
                    @else
                        <div class="w-6 h-6 rounded-full bg-gray-300"></div>
                    @endif

                    @if(!$loop->last)
                        <div class="w-px h-5 bg-gray-300"></div>
                    @endif
                </div>

                {{-- CONTENT --}}
                <div class="flex-1">

                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-700 capitalize">
                            {{ $step->role_verifikator }}
                        </p>

                        {{-- BADGE --}}
                        @if($isDone)
                            <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full border border-green-100">Disetujui</span>
                        @elseif($isReject)
                            <span class="text-xs px-2 py-1 bg-red-50 text-red-600 rounded-full border border-red-100">Ditolak</span>
                        @elseif(!$status)
                            <span class="text-xs px-2 py-1 bg-amber-50 text-amber-700 rounded-full border border-amber-100">Menunggu</span>
                        @endif
                    </div>

                    {{-- WAKTU --}}
                    @if($verif && $verif->waktu_verifikasi)
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($verif->waktu_verifikasi)->translatedFormat('d F Y H:i') }}
                        </p>
                    @endif

                    {{-- CATATAN --}}
                    @if($verif && $verif->catatan)
                        <p class="text-xs text-gray-500 italic mt-1">
                            "{{ $verif->catatan }}"
                        </p>
                    @endif

                </div>

            </div>

        @endforeach

        {{-- FINAL STATUS --}}
        <div class="flex gap-3 items-start">

            <div class="mt-1">
                @if($peminjaman->status === 'disetujui')
                    <div class="w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold">✓</div>
                @elseif($peminjaman->status === 'ditolak')
                    <div class="w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center text-xs font-bold">✕</div>
                @else
                    <div class="w-6 h-6 rounded-full bg-gray-300"></div>
                @endif
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-700">Selesai</p>
                <p class="text-xs text-gray-500">
                    Status akhir pengajuan
                </p>
            </div>

        </div>

    </div>
</div>

    <!-- Button -->
    <div class="flex justify-end mt-10">

        <a href="{{ route('dosen.list-peminjaman') }}"
           class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
            Kembali
        </a>

    </div>

</div>

</x-master>
