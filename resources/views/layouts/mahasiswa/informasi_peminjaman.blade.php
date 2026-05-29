<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Informasi Peminjaman Ruang
            </h1>
            <p class="mt-0.5 text-sm text-slate-500">
                Panduan alur peminjaman ruangan untuk mahasiswa berdasarkan hari peminjaman dan jenis ruangan.
            </p>
        </div>

        {{-- INFO PEMBEDA --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-white text-blue-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-info text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-blue-700 mb-1">
                        Ketentuan Alur Peminjaman
                    </h2>
                    <p class="text-sm text-blue-700 leading-relaxed">
                        Alur peminjaman ruangan dibedakan berdasarkan hari peminjaman, yaitu
                        <span class="font-semibold">Weekday</span> untuk hari Senin sampai Jumat dan
                        <span class="font-semibold">Weekend</span> untuk hari Sabtu atau Minggu.
                        Peminjaman ruang tertentu seperti <span class="font-semibold">LAB</span> dapat membutuhkan
                        persyaratan tambahan sesuai ketentuan penanggung jawab ruangan.
                    </p>
                </div>
            </div>
        </div>

        {{-- PERBEDAAN SINGKAT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700 border border-green-100">
                        Weekday
                    </span>
                    <span class="text-xs text-slate-400 font-semibold">Senin - Jumat</span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Peminjaman mengikuti alur normal pada jam operasional kampus.
                    Untuk ruang kelas biasa, mahasiswa cukup mengisi form pengajuan dengan data lengkap.
                    Untuk ruang LAB, mahasiswa dapat diminta melampirkan dokumen pendukung atau mengikuti ketentuan penggunaan LAB.
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700 border border-orange-100">
                        Weekend
                    </span>
                    <span class="text-xs text-slate-400 font-semibold">Sabtu - Minggu</span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Peminjaman berada di luar hari kerja sehingga membutuhkan persyaratan tambahan.
                    Mahasiswa perlu memastikan kegiatan, waktu penggunaan, dan penanggung jawab kegiatan jelas.
                    Untuk ruang LAB, pengajuan dapat memerlukan persetujuan tambahan dari pihak terkait.
                </p>
            </div>
        </div>

        {{-- GRID ALUR --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            {{-- ALUR WEEKDAY --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden self-start">
                <button type="button"
                    onclick="toggleAlur('alurWeekday', 'iconWeekday')"
                    class="w-full px-6 py-5 flex items-center justify-between hover:bg-slate-50 transition">

                    <div class="text-left">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 border border-green-100">
                                Weekday
                            </span>
                            <span class="text-xs text-slate-400 font-semibold">Senin - Jumat</span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Alur Peminjaman Weekday
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Alur normal untuk peminjaman pada hari kerja.
                        </p>
                    </div>

                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                        <i id="iconWeekday" class="fa-solid fa-angle-down transition-transform duration-300"></i>
                    </div>
                </button>

                <div id="alurWeekday" class="hidden border-t border-slate-100 px-6 py-5">
                    <div class="space-y-4">

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mahasiswa membuka menu Peminjaman</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa memilih menu peminjaman ruang untuk melihat ruangan yang tersedia.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Memilih ruangan dan jadwal</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa memilih ruangan, tanggal, dan waktu peminjaman sesuai kebutuhan kegiatan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mengisi form pengajuan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa mengisi data kegiatan, keperluan, tanggal, waktu, serta informasi pemohon dengan lengkap.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melengkapi persyaratan ruang</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Untuk ruang kelas biasa, pengajuan diproses melalui alur normal. Untuk ruang LAB, mahasiswa perlu mengikuti ketentuan penggunaan LAB dan melampirkan dokumen pendukung jika diminta.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Menunggu proses verifikasi</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Pengajuan akan diverifikasi oleh pihak terkait sesuai alur peminjaman ruang pada hari kerja.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">6</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melihat status pengajuan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa dapat melihat status pengajuan melalui menu Peminjaman atau Riwayat.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ALUR WEEKEND --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden self-start">
                <button type="button"
                    onclick="toggleAlur('alurWeekend', 'iconWeekend')"
                    class="w-full px-6 py-5 flex items-center justify-between hover:bg-slate-50 transition">

                    <div class="text-left">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700 border border-orange-100">
                                Weekend
                            </span>
                            <span class="text-xs text-slate-400 font-semibold">Sabtu - Minggu</span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Alur Peminjaman Weekend
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Alur khusus untuk peminjaman di luar hari kerja.
                        </p>
                    </div>

                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                        <i id="iconWeekend" class="fa-solid fa-angle-down transition-transform duration-300"></i>
                    </div>
                </button>

                <div id="alurWeekend" class="hidden border-t border-slate-100 px-6 py-5">
                    <div class="space-y-4">

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mahasiswa membuka menu Peminjaman</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa memilih menu peminjaman ruang untuk mengajukan penggunaan ruangan pada akhir pekan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Memilih ruangan dan jadwal weekend</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa memilih ruangan, tanggal weekend, serta waktu penggunaan sesuai kebutuhan kegiatan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mengisi form pengajuan dengan lengkap</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa mengisi data kegiatan, keperluan, waktu penggunaan, jumlah peserta, dan penanggung jawab kegiatan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melampirkan dokumen pendukung</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Karena dilakukan di luar hari kerja, mahasiswa perlu melampirkan dokumen pendukung seperti surat izin kegiatan atau bukti persetujuan pihak terkait jika diperlukan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Persyaratan tambahan untuk ruang LAB</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Jika ruangan yang dipinjam adalah LAB, pengajuan dapat memerlukan persetujuan tambahan dari penanggung jawab LAB, laboran, atau pihak terkait.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">6</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Menunggu verifikasi khusus weekend</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Pengajuan weekend diproses melalui verifikasi tambahan karena kegiatan dilakukan di luar hari kerja.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">7</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melihat status pengajuan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Mahasiswa dapat melihat status pengajuan melalui menu Peminjaman atau Riwayat.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">8</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mengikuti ketentuan penggunaan ruang</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Jika disetujui, mahasiswa wajib menggunakan ruangan sesuai jadwal, menjaga fasilitas, dan mematuhi ketentuan penggunaan ruang.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- CATATAN --}}
        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-white text-amber-500 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-amber-700 mb-1">
                        Catatan Penting
                    </h2>
                    <p class="text-sm text-amber-700 leading-relaxed">
                        Persyaratan dapat berbeda tergantung jenis ruangan, waktu peminjaman, dan kebijakan pihak terkait.
                        Peminjaman ruang LAB pada weekend umumnya membutuhkan perhatian lebih karena berkaitan dengan penggunaan alat,
                        keamanan ruang, dan penanggung jawab kegiatan.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function toggleAlur(contentId, iconId) {
    const content = document.getElementById(contentId);
    const icon = document.getElementById(iconId);

    content.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
</script>

</x-master>
