<x-master>

    <div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                    Jenis Ruang
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Kelola kategori ruangan yang tersedia di seluruh gedung kampus.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-tags text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Jenis</p>
                        <p class="text-xl font-extrabold text-slate-800">{{ $jenisRuang->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM TAMBAH --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">
                <i class="fa-solid fa-plus text-blue-400 mr-1"></i>
                Tambah Jenis Ruang
            </p>
            <form method="POST" action="{{ route('kasubag.jenis-ruang.store') }}" class="flex items-start gap-3">
                @csrf
                <div class="relative flex-1">
                    <i class="fa-solid fa-tag absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="text" name="nama" placeholder="Contoh: Ruang Kuliah" maxlength="25" required
                        class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition" />
                </div>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200 inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-10">#</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Jenis Ruang</th>
                            <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">

                        @forelse($jenisRuang as $index => $item)
                            <tr id="row-{{ $item->slug }}" class="hover:bg-slate-50/70 transition-colors group">

                                <td class="px-5 py-4 text-xs font-semibold text-slate-400">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-blue-50 text-primary rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-tag text-sm"></i>
                                        </div>
                                        <span class="font-semibold text-slate-800 text-sm">
                                            {{ $item->nama }}
                                        </span>
                                    </div>

                                    <form id="editForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="nama" id="editNama">
                                    </form>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">

                                        <button type="button"
                                            onclick="editJenisRuang('{{ $item->slug }}','{{ $item->nama }}')"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-orange-50 text-orange-500 hover:bg-orange-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                            <i class="fa-solid fa-pen text-sm"></i>
                                        </button>

                                        <form method="POST"
                                            action="{{ route('kasubag.jenis-ruang.destroy', $item->slug) }}"
                                            onsubmit="return onDelete(event,'{{ $item->nama }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-9 h-9 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl transition-colors opacity-60 group-hover:opacity-100">
                                                <i class="fa-solid fa-trash text-sm"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-500 text-sm">Belum ada jenis ruang</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Tambahkan jenis ruang menggunakan form di atas.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function editJenisRuang(slug, nama) {
            Swal.fire({
                title: 'Edit Jenis Ruang',
                input: 'text',
                inputValue: nama,
                inputLabel: 'Nama Jenis Ruang',
                inputPlaceholder: 'Masukkan nama baru',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                inputValidator: (value) => {
                    if (!value) return 'Nama tidak boleh kosong!'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('editForm')
                    form.action = `/kasubag/jenis-ruang/${slug}`
                    document.getElementById('editNama').value = result.value
                    form.submit()
                }
            })
        }

        function onDelete(event, nama) {
            event.preventDefault()
            const form = event.currentTarget
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Jenis ruang "${nama}" akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit()
            })
            return false
        }
    </script>

</x-master>
