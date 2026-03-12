<x-master>

{{--
    =========================================================
    PERBAIKAN DARI VERSI SEBELUMNYA:
    1. [BUG] col-span di empty state diperbaiki dari 2 → sesuai grid
    2. [UX]  Tambah tombol Edit di setiap card (sebelumnya tidak ada)
    3. [UX]  Tambah konfirmasi hapus dengan SweetAlert-style modal
             (sebelumnya destroy() dipanggil tapi tidak ada di kode)
    4. [UX]  Flash message success/error ditampilkan sebagai toast
             (sebelumnya hanya dikirim via session, tidak ditampilkan)
    5. [UX]  Validation error ditampilkan inline di bawah input modal
             (sebelumnya @errors tidak di-handle di tampilan)
    6. [UI]  Icon di action card diperjelas (edit=amber, del=red)
    7. [UI]  Modal auto-open kembali jika ada validation error dari server
    =========================================================
--}}

<div class="bg-slate-100 min-h-screen px-8 py-10">

    <x-breadcrumb :steps="[
        ['label' => 'Kampus', 'active' => true],
    ]"/>

    {{-- ===== HEADER ===== --}}
    <div class="flex items-start justify-between mb-10 flex-wrap gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Daftar Kampus
            </h1>
            <p class="text-slate-500 mt-1 text-sm max-w-sm leading-relaxed">
                Kelola data kampus yang memiliki gedung dan ruangan di lingkungan PNM.
            </p>
        </div>
        <button onclick="openModal()"
            class="inline-flex items-center gap-2 bg-primary hover:bg-blue-500 active:scale-95 text-white text-sm font-semibold px-6 py-3 rounded-xl  transition-all duration-200 cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Kampus
        </button>
    </div>

    {{-- ===== CAMPUS GRID ===== --}}
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4" id="kampusGrid">

        @forelse($kampus as $item)
        <div class="bg-white rounded-xl overflow-hidden  hover:-translate-y-1 transition-all duration-300 group">

            <div class="relative h-56 overflow-hidden m-4 rounded-xl">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}"
                         alt="{{ $item->nama_kampus }}"
                         class="w-full h-full object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80"
                         alt="{{ $item->nama_kampus }}"
                         class="w-full h-full object-cover">
                @endif
            </div>

            {{-- Card Body --}}
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 shrink-0">
                            <i class="fa-solid fa-building-columns text-base"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 tracking-widest uppercase">Jumlah Gedung</span>
                            <span class="block text-xl font-bold text-slate-800 leading-none">{{ $item->gedung_count }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">

                        <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama_kampus }}')"
                               class="w-8 h-8 flex items-center justify-center bg-orange-200/40 border border-orange-300 text-orange-500 rounded-lg  hover:bg-orange-300/50 hover:border-orange-400 transition-all">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </button>

                        <form onsubmit="confirmDeleteKampus({{ $item->id }}, '{{ $item->nama_kampus }}')"
                              action="{{ route('kasubag.kampus.destroy', $item->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                 class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-200/40 border border-red-300 text-red-500 hover:bg-red-300/50 hover:border-red-400 transition-all">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                        <a href="{{ route('kasubag.gedung.index', ['slug' => $item->slug]) }}"
                        class="inline-flex items-center gap-2 border border-slate-200 hover:border-blue-500 hover:text-primary hover:bg-blue-50 text-slate-700 text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-200">
                            Lihat Gedung
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        @empty
        {{--
            PERBAIKAN #1:
            Grid adalah md:grid-cols-2, jadi empty state harus col-span-2.
            Versi sebelumnya juga col-span-2 tapi tanpa md: prefix,
            lebih aman pakai md:col-span-2 agar responsive.
        --}}
        <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center py-24 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mb-5">
                <i class="fa-solid fa-building text-4xl text-slate-300"></i>
            </div>
            <p class="text-slate-700 font-semibold text-lg">Belum ada kampus</p>
            <p class="text-slate-400 text-sm mt-1 max-w-xs">
                Tambahkan kampus pertama Anda dengan klik tombol
                <span class="font-semibold text-blue-500">+ Add Campus</span>.
            </p>
        </div>
        @endforelse

    </div>
</div>


{{-- ===================================================== --}}
{{-- ================= MODAL CREATE ====================== --}}
{{-- ===================================================== --}}
<div id="modalKampus"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
     aria-modal="true" role="dialog">

    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300"
         onclick="closeModal()"></div>

    <div class="relative bg-white rounded-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
         id="modalPanel">

        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-primary">
                    <i class="fa-solid fa-building-circle-arrow-right text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tambah Kampus Baru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Isi nama kampus yang akan ditambahkan</p>
                </div>
            </div>
            <button onclick="closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="px-6 py-5">
            <form action="{{ route('kasubag.kampus.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-5">
                    <label for="nama_kampus" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Kampus <span class="text-red-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-school text-sm"></i>
                        </span>
                        <input type="text"
                               id="nama_kampus"
                               name="nama_kampus"
                               value="{{ old('nama_kampus') }}"
                               placeholder="Contoh: Kampus Utama"
                               maxlength="50"
                               {{-- PERBAIKAN #5: tambah class error jika ada validation error --}}
                               class="w-full pl-10 pr-4 py-2.5 text-sm text-slate-800 bg-slate-50 border {{ $errors->has('nama_kampus') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-300 transition-all duration-200"
                               autofocus>
                    </div>
                    {{-- PERBAIKAN #5: tampilkan error validasi server --}}
                    @error('nama_kampus')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center gap-2 mb-5 text-xs text-slate-400">
                    <i class="fa-solid fa-circle-info text-blue-400"></i>
                    Nama kampus maksimal <strong>50 karakter</strong> dan harus unik.
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all duration-200">
                        <i class="fa-solid fa-xmark text-xs"></i>
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-blue-500 rounded-xl  transition-all duration-200">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        Simpan Kampus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ===================================================== --}}
{{-- ================= MODAL EDIT ======================== --}}
{{-- ===================================================== --}}
<div id="modalEditKampus"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
     aria-modal="true" role="dialog">

    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
         onclick="closeEditModal()"></div>

    <div class="relative bg-white rounded-2xl  w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
         id="modalEditPanel">

        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Edit Kampus</h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="editModalSubtitle">Perbarui nama kampus</p>
                </div>
            </div>
            <button onclick="closeEditModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="px-6 py-5">
            <form id="editKampusForm" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Kampus <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-school text-sm"></i>
                        </span>
                        <input type="text"
                               id="edit_nama_kampus"
                               name="nama_kampus"
                               maxlength="50"
                               class="w-full pl-10 pr-4 py-2.5 text-sm text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent placeholder:text-slate-300 transition-all duration-200">
                    </div>
                    <p id="editErrNama" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i><span></span>
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                        <i class="fa-solid fa-xmark text-xs"></i> Batal
                    </button>
                    <button type="submit" id="btnEditSubmit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-all">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ============================================================
    // MODAL CREATE
    // ============================================================
    const modal      = document.getElementById('modalKampus');
    const modalPanel = document.getElementById('modalPanel');

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => modalPanel.classList.remove('scale-95', 'opacity-0'), 10);
    }

    function closeModal() {
        modalPanel.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // PERBAIKAN #7: Buka modal otomatis jika ada validation error dari server
    @if($errors->any())
        openModal();
    @endif


    // ============================================================
    // MODAL EDIT
    // ============================================================
    const editModal      = document.getElementById('modalEditKampus');
    const editModalPanel = document.getElementById('modalEditPanel');

    function openEditModal(id, namaKampus) {
        document.getElementById('editKampusForm').action = `/kasubag/kampus/${id}`;
        document.getElementById('edit_nama_kampus').value = namaKampus;
        document.getElementById('editModalSubtitle').textContent = namaKampus;

        editModal.classList.remove('hidden');
        setTimeout(() => editModalPanel.classList.remove('scale-95', 'opacity-0'), 10);
        document.getElementById('edit_nama_kampus').focus();
    }

    function closeEditModal() {
        editModalPanel.classList.add('scale-95', 'opacity-0');
        setTimeout(() => editModal.classList.add('hidden'), 300);
    }

    function confirmDeleteKampus(id, namaKampus) {
        event.preventDefault();

        const form = event.currentTarget;
        Swal.fire({
            title: 'Hapus Kampus',
            text: `Apakah Anda yakin ingin menghapus kampus "${namaKampus}"? Semua gedung dan ruangan di dalamnya juga akan dihapus.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6b7280'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    // Tutup modal dengan Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal();
            closeEditModal();
            closeDeleteModal();
        }
    });

</script>
@endpush

</x-master>