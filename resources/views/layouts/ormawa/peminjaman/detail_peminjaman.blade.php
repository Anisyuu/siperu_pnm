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
        Timeline Verifikasi
    </h3>

    <div class="space-y-8">

        <!-- Step 1 -->
        <div class="flex gap-4">

            <div class="flex flex-col items-center">
                <div class="w-4 h-4 bg-primary rounded-full"></div>
                <div class="w-px bg-gray-300 flex-1"></div>
            </div>

            <div>
                <p class="font-semibold text-text-main">
                    Pengajuan Dibuat
                </p>

                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal)->locale('id')->translatedFormat('d F Y') }}
                </p>

                <p class="text-sm text-gray-500">
                    Pengajuan dibuat oleh Ormawa
                </p>
            </div>

        </div>


        <!-- Step 2 -->
        <div class="flex gap-4">

            <div class="flex flex-col items-center">

                @if($peminjaman->status == 'pending_pimpinan')
                    <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
                @else
                    <div class="w-4 h-4 bg-primary rounded-full"></div>
                @endif

                <div class="w-px bg-gray-300 flex-1"></div>

            </div>

            <div>

                <p class="font-semibold">
                    Verifikasi Pimpinan
                </p>

                <p class="text-sm text-gray-500">
                    Pengajuan diperiksa oleh pimpinan unit
                </p>

            </div>

        </div>


        <!-- Step 3 -->
        <div class="flex gap-4">

            <div class="flex flex-col items-center">

                @if($peminjaman->status == 'pending_kasubag')
                    <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
                @elseif(in_array($peminjaman->status,['pending_sarpras','selesai']))
                    <div class="w-4 h-4 bg-primary rounded-full"></div>
                @else
                    <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                @endif

                <div class="w-px bg-gray-300 flex-1"></div>

            </div>

            <div>

                <p class="font-semibold">
                    Verifikasi Kasubag
                </p>

                <p class="text-sm text-gray-500">
                    Pengajuan diverifikasi oleh Kepala Sub Bagian
                </p>

            </div>

        </div>


        <!-- Step 4 -->
        <div class="flex gap-4">

            <div class="flex flex-col items-center">

                @if($peminjaman->status == 'pending_sarpras')
                    <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
                @elseif($peminjaman->status == 'selesai')
                    <div class="w-4 h-4 bg-primary rounded-full"></div>
                @else
                    <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                @endif

                <div class="w-px bg-gray-300 flex-1"></div>

            </div>

            <div>

                <p class="font-semibold">
                    Verifikasi Sarpras Gedung
                </p>

                <p class="text-sm text-gray-500">
                    Pemeriksaan ketersediaan ruangan oleh pengelola gedung
                </p>

            </div>

        </div>


        <!-- Step 5 -->
        <div class="flex gap-4">

            <div>

                @if($peminjaman->status == 'selesai')
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                @else
                    <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                @endif

            </div>

            <div>

                <p class="font-semibold">
                    Selesai
                </p>

                <p class="text-sm text-gray-500">
                    Pengajuan peminjaman ruangan telah selesai diproses
                </p>

            </div>

        </div>

    </div>

</div>


    <!-- Button -->
    <div class="flex justify-end mt-10">

        <a href="{{ route('ormawa.list-peminjaman') }}"
           class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
            Kembali
        </a>

    </div>

</div>

</x-master>
