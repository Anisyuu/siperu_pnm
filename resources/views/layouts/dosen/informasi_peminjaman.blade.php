<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Informasi Peminjaman Ruang
            </h1>
            <p class="mt-0.5 text-sm text-slate-500">
                Panduan alur peminjaman ruangan untuk dosen
            </p>
        </div>

        {{-- ALUR --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-5">
                Alur Peminjaman Dosen
            </h2>

            <div class="space-y-4">
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Dosen membuka menu Peminjaman</p>
                        <p class="text-sm text-slate-500 mt-0.5">Dosen memilih ruangan yang akan digunakan untuk kegiatan akademik atau nonakademik.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Mengisi detail peminjaman</p>
                        <p class="text-sm text-slate-500 mt-0.5">Dosen mengisi tanggal, waktu, nama kegiatan, ruangan, dan keterangan tambahan jika diperlukan.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Menunggu persetujuan</p>
                        <p class="text-sm text-slate-500 mt-0.5">Pengajuan dosen akan diverifikasi sesuai alur yang telah ditentukan.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Menggunakan ruangan setelah disetujui</p>
                        <p class="text-sm text-slate-500 mt-0.5">Ruangan dapat digunakan apabila status pengajuan sudah disetujui.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</x-master>
