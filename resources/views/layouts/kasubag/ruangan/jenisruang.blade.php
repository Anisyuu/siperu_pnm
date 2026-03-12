<x-master>

    <div class="bg-slate-100 min-h-screen px-8 py-10">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-8 flex-wrap gap-4">

            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Jenis Ruang
                </h1>

                <p class="text-slate-500 mt-1 text-sm">
                    Kelola kategori ruangan yang tersedia di seluruh gedung kampus.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">

                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-tags text-blue-500 text-sm"></i>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Total Jenis</div>
                        <div class="text-xl font-extrabold text-slate-800">
                            {{ $jenisRuang->count() }}
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- MAIN CARD --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            {{-- FORM TAMBAH --}}
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/40">

                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">
                    <i class="fa-solid fa-plus text-blue-400 mr-1"></i>
                    Tambah Jenis Ruang
                </p>

                <form method="POST" action="{{ route('kasubag.jenis-ruang.store') }}" class="flex items-start gap-3">

                    @csrf

                    <div class="flex-1">

                        <div class="relative">

                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fa-solid fa-tag text-sm"></i>
                            </span>

                            <input type="text" name="nama" placeholder="Contoh: Ruang Kuliah" maxlength="25"
                                required
                                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500">

                        </div>

                    </div>

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-blue-500 rounded-xl">

                        <i class="fa-solid fa-plus text-xs"></i>
                        Tambah

                    </button>

                </form>

            </div>



            {{-- TABEL --}}
            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="border-b border-slate-100">

                            <th class="text-left px-6 py-3 text-[11px] font-bold text-slate-400 uppercase w-10">#</th>

                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">
                                Nama Jenis Ruang
                            </th>

                            <th class="text-right px-6 py-3 text-[11px] font-bold text-slate-400 uppercase">
                                Aksi
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-slate-50">

                        @forelse($jenisRuang as $index => $item)
                            <tr id="row-{{ $item->slug }}" class="hover:bg-slate-50">

                                <td class="px-6 py-4 text-slate-400 text-xs font-semibold">
                                    {{ $index + 1 }}
                                </td>



                                {{-- NAMA --}}
                                <td class="px-4 py-4">

                                    {{-- VIEW MODE --}}
                                    <div class="view-mode flex items-center gap-3">

                                        <div
                                            class="w-9 h-9 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                                            <i class="fa-solid fa-tag text-sm"></i>
                                        </div>

                                        <span class="font-semibold text-slate-800">
                                            {{ $item->nama }}
                                        </span>

                                    </div>

                                    <form id="editForm" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="nama" id="editNama">
                                    </form>
                                </td>



                                {{-- AKSI --}}
                                <td class="px-6 py-4">

                                    <div class="view-mode flex justify-end gap-1">

                                        <button type="button"
                                            onclick="editJenisRuang('{{ $item->slug }}','{{ $item->nama }}')"
                                            class="w-8 h-8 flex items-center justify-center bg-orange-200/40 border border-orange-300 text-orange-500 rounded-lg  hover:bg-orange-300/50 hover:border-orange-400 transition-all">

                                            <i class="fa-solid fa-pen text-sm"></i>

                                        </button>

                                        <form method="POST"
                                            action="{{ route('kasubag.jenis-ruang.destroy', $item->slug) }}"
                                            onsubmit="return onDelete(event,'{{ $item->nama }}')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-200/40 border border-red-300 text-red-500 hover:bg-red-300/50 hover:border-red-400 transition-all">

                                                <i class="fa-solid fa-trash text-sm"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada jenis ruang
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- JS EDIT TOGGLE --}}
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
                    if (!value) {
                        return 'Nama tidak boleh kosong!'
                    }
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

                if (result.isConfirmed) {
                    form.submit()
                }

            })

            return false
        }
    </script>

</x-master>
