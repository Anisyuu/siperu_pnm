<x-master>

<div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Informasi Peminjaman Ruang
            </h1>
            <p class="mt-0.5 text-sm text-slate-500">
                Panduan alur peminjaman ruangan untuk ormawa berdasarkan hari peminjaman dan jenis ruangan.
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
                        Alur peminjaman ruangan untuk ormawa dibedakan berdasarkan hari peminjaman, yaitu
                        <span class="font-semibold">Weekday</span> untuk hari Senin sampai Jumat dan
                        <span class="font-semibold">Weekend</span> untuk hari Sabtu atau Minggu.
                        Peminjaman untuk kegiatan organisasi dapat membutuhkan dokumen pendukung kegiatan.
                        Jika ruangan yang dipinjam adalah <span class="font-semibold">LAB</span>, pengajuan dapat membutuhkan persetujuan tambahan.
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
                    Peminjaman pada hari kerja mengikuti alur normal. Ormawa dapat mengajukan ruangan untuk rapat,
                    persiapan kegiatan, pelatihan, seminar, atau kegiatan organisasi lainnya. Dokumen pendukung dapat dilampirkan
                    sesuai kebutuhan kegiatan.
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
                    Peminjaman pada akhir pekan membutuhkan perhatian tambahan karena berada di luar hari kerja.
                    Ormawa perlu memastikan kegiatan, waktu penggunaan, jumlah peserta, penanggung jawab, dan dokumen pendukung kegiatan sudah jelas.
                </p>
            </div>
        </div>

        {{-- GRID ALUR --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            {{-- ALUR WEEKDAY --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden self-start">
                <button type="button"
                    onclick="toggleAlur('alurOrmawaWeekday', 'iconOrmawaWeekday')"
                    class="w-full px-6 py-5 flex items-center justify-between hover:bg-slate-50 transition">

                    <div class="text-left">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 border border-green-100">
                                Weekday
                            </span>
                            <span class="text-xs text-slate-400 font-semibold">Senin - Jumat</span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Alur Peminjaman Ormawa Weekday
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Alur normal untuk peminjaman ruangan kegiatan organisasi pada hari kerja.
                        </p>
                    </div>

                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                        <i id="iconOrmawaWeekday" class="fa-solid fa-angle-down transition-transform duration-300"></i>
                    </div>
                </button>

                <div id="alurOrmawaWeekday" class="hidden border-t border-slate-100 px-6 py-5">
                    <div class="space-y-4">

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Ormawa membuka menu Peminjaman</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa membuka menu peminjaman untuk melihat ruangan yang tersedia.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Memilih ruangan dan jadwal</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa memilih ruangan, tanggal, dan waktu penggunaan sesuai kebutuhan kegiatan organisasi.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mengisi form kegiatan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa mengisi nama kegiatan, jadwal, kebutuhan ruangan, jumlah peserta, dan penanggung jawab kegiatan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melampirkan dokumen pendukung jika diperlukan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Dokumen pendukung kegiatan dapat dilampirkan sesuai kebutuhan, seperti surat kegiatan atau proposal kegiatan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Diproses oleh verifikator</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Pengajuan akan melalui proses verifikasi sesuai alur peminjaman ruang yang berlaku.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold flex-shrink-0">6</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melihat hasil pengajuan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa dapat mengecek status pengajuan melalui menu Peminjaman atau Riwayat.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ALUR WEEKEND --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden self-start">
                <button type="button"
                    onclick="toggleAlur('alurOrmawaWeekend', 'iconOrmawaWeekend')"
                    class="w-full px-6 py-5 flex items-center justify-between hover:bg-slate-50 transition">

                    <div class="text-left">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700 border border-orange-100">
                                Weekend
                            </span>
                            <span class="text-xs text-slate-400 font-semibold">Sabtu - Minggu</span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Alur Peminjaman Ormawa Weekend
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Alur khusus untuk peminjaman kegiatan organisasi di luar hari kerja.
                        </p>
                    </div>

                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                        <i id="iconOrmawaWeekend" class="fa-solid fa-angle-down transition-transform duration-300"></i>
                    </div>
                </button>

                <div id="alurOrmawaWeekend" class="hidden border-t border-slate-100 px-6 py-5">
                    <div class="space-y-4">

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Ormawa membuka menu Peminjaman</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa membuka menu peminjaman untuk mengajukan penggunaan ruangan pada akhir pekan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Memilih ruangan dan jadwal weekend</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa memilih ruangan, tanggal weekend, serta waktu penggunaan sesuai kebutuhan kegiatan organisasi.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Mengisi form kegiatan dengan lengkap</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa mengisi nama kegiatan, keperluan, waktu penggunaan, jumlah peserta, dan penanggung jawab kegiatan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melampirkan dokumen kegiatan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Karena kegiatan dilakukan di luar hari kerja, ormawa perlu melampirkan dokumen kegiatan seperti surat izin,
                                    proposal kegiatan, atau dokumen pendukung lainnya jika diperlukan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Persyaratan tambahan untuk ruang LAB</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Jika ruangan yang dipinjam adalah LAB, pengajuan dapat memerlukan persetujuan tambahan dari penanggung jawab LAB,
                                    laboran, atau pihak terkait karena berkaitan dengan fasilitas dan perangkat laboratorium.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">6</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Diproses oleh verifikator khusus weekend</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Pengajuan weekend akan diproses melalui verifikasi tambahan karena kegiatan dilakukan di luar hari kerja.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">7</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Melihat hasil pengajuan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Ormawa dapat mengecek status pengajuan melalui menu Peminjaman atau Riwayat.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">8</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">Menggunakan ruangan sesuai ketentuan</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Jika pengajuan disetujui, ormawa wajib menggunakan ruangan sesuai jadwal, menjaga fasilitas,
                                    dan mematuhi ketentuan penggunaan ruang.
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
                        Persyaratan dapat berbeda tergantung jenis ruangan, waktu peminjaman, skala kegiatan, dan kebijakan pihak terkait.
                        Peminjaman ruang LAB pada weekend umumnya membutuhkan perhatian lebih karena berkaitan dengan penggunaan fasilitas,
                        perangkat laboratorium, keamanan ruang, dan penanggung jawab kegiatan.
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
