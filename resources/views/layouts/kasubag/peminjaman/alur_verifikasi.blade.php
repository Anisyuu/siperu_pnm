<x-master>

    <div class="bg-slate-100 min-h-screen px-8 py-10">
    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                    Alur Verifikasi
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Kelola alur verifikasi untuk berbagai jenis pemohon.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 shadow-sm">
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-list-check text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Alur</p>
                        <p class="text-xl font-extrabold text-slate-800">{{ $totalAlur }}</p>
                    </div>
                </div>
                <button onclick="openModal()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-2xl shadow-sm hover:brightness-110 active:scale-95 transition">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah Alur
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-12">#</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jenis Pemohon</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alur Verifikasi</th>
                            <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse($alurVerifikasi as $jenis => $items)
                            <tr class="hover:bg-slate-50/70 transition-colors group">

                                <td class="px-5 py-4 text-xs font-semibold text-slate-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg capitalize">
                                        <i class="fa-solid fa-user-tag text-[10px]"></i>
                                        {{ $jenis }}
                                    </span>
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @foreach($items as $i => $step)
                                            @if($i > 0)
                                                <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
                                            @endif
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-lg">
                                                <span class="w-4 h-4 bg-white border border-slate-200 rounded-md flex items-center justify-center text-[10px] font-extrabold text-slate-500">
                                                    {{ $step->urutan }}
                                                </span>
                                                {{ $step->role_verifikator }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2 opacity-60 group-hover:opacity-100 transition-opacity">

                                        <button onclick="editAlur('{{ $jenis }}')"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-orange-50 text-orange-500 hover:bg-orange-100 rounded-xl transition-colors">
                                            <i class="fa-solid fa-pen text-sm"></i>
                                        </button>

                                        <button onclick="confirmDelete('{{ $jenis }}')"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl transition-colors">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>

                                        <form id="delete-form-{{ Str::slug($jenis) }}"
                                            method="POST"
                                            action="{{ route('kasubag.alur-verifikasi.destroy', $jenis) }}"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                            <i class="fa-solid fa-diagram-project text-2xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-500 text-sm">Belum ada alur verifikasi</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Klik tombol "Tambah Alur" untuk mulai membuat.</p>
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


    {{-- MODAL --}}
    <div id="modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4"
        onclick="handleBackdropClick(event)">

        <div id="modalPanel"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-[500px] transform transition-all duration-200 scale-95 opacity-0">

            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div>
                    <h2 class="font-extrabold text-slate-800 text-base" id="modalTitle">Tambah Alur Verifikasi</h2>
                    <p class="text-xs text-slate-400 mt-0.5" id="modalSubtitle">Pilih jenis pemohon dan tentukan urutan verifikator.</p>
                </div>
                <button onclick="closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="formAlur" method="POST" action="{{ route('kasubag.alur-verifikasi.store') }}">
                @csrf

                <div class="px-6 py-5 space-y-4">

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                            Jenis Pemohon
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-user-tag absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <select name="jenis_pemohon" id="jenisPemohon"
                                class="w-full border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 appearance-none transition">
                                <option value="">-- Pilih Jenis Pemohon --</option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Urutan Verifikator
                            </label>
                            <button type="button" onclick="addStep()"
                                class="inline-flex items-center gap-1 text-xs font-semibold text-blue-500 hover:text-blue-700 transition-colors">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                                Tambah Step
                            </button>
                        </div>

                        <div id="stepContainer" class="space-y-2 max-h-60 overflow-y-auto pr-1"></div>

                        <p id="emptyStepHint" class="text-xs text-slate-400 text-center py-4 border border-dashed border-slate-200 rounded-xl mt-2">
                            Belum ada step. Klik "+ Tambah Step" untuk menambahkan.
                        </p>
                    </div>

                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-2 rounded-b-2xl">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-primary hover:brightness-110 active:scale-95 rounded-xl transition-all shadow-sm shadow-blue-200">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>


@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const roles = @json($role);

    const modal      = document.getElementById('modal');
    const modalPanel = document.getElementById('modalPanel');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(() => {
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeModal() {
        modalPanel.classList.add('scale-95', 'opacity-0');
        modalPanel.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            resetModal();
        }, 200);
    }

    function handleBackdropClick(e) {
        if (e.target === modal) closeModal();
    }

    function resetModal() {
        document.getElementById('formAlur').reset();
        document.getElementById('stepContainer').innerHTML = '';
        document.getElementById('modalTitle').textContent    = 'Tambah Alur Verifikasi';
        document.getElementById('modalSubtitle').textContent = 'Pilih jenis pemohon dan tentukan urutan verifikator.';
        document.getElementById('jenisPemohon').removeAttribute('disabled');
        updateEmptyHint();
    }

    function getRoleOptions(selected = '') {
        return roles.map(r =>
            `<option value="${r.nama}" ${r.nama === selected ? 'selected' : ''}>${r.nama}</option>`
        ).join('');
    }

    function addStep(value = '') {
        const container = document.getElementById('stepContainer');
        const div = document.createElement('div');
        div.className = 'step-item flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2';
        div.innerHTML = `
            <span class="step-number w-6 h-6 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-slate-500 flex-shrink-0">1</span>
            <div class="relative flex-1">
                <select name="role_verifikator[]"
                    class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300 appearance-none transition">
                    ${getRoleOptions(value)}
                </select>
                <i class="fa-solid fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[9px] pointer-events-none"></i>
            </div>
            <button type="button" onclick="removeStep(this)"
                class="w-7 h-7 flex items-center justify-center text-red-400 hover:bg-red-50 hover:text-red-500 rounded-lg transition-colors flex-shrink-0">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        `;
        container.appendChild(div);
        reindexStep();
        updateEmptyHint();
    }

    function removeStep(btn) {
        btn.closest('.step-item').remove();
        reindexStep();
        updateEmptyHint();
    }

    function reindexStep() {
        document.querySelectorAll('.step-item .step-number').forEach((el, i) => {
            el.textContent = i + 1;
        });
    }

    function updateEmptyHint() {
        const hint  = document.getElementById('emptyStepHint');
        const count = document.querySelectorAll('.step-item').length;
        hint.classList.toggle('hidden', count > 0);
    }

    function editAlur(jenis) {
        fetch(`/kasubag/alur-verifikasi/${jenis}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('jenisPemohon').value = jenis;
                document.getElementById('jenisPemohon').setAttribute('disabled', true);
                document.getElementById('modalTitle').textContent    = 'Edit Alur Verifikasi';
                document.getElementById('modalSubtitle').textContent = `Mengedit alur untuk jenis: ${jenis}`;
                document.getElementById('stepContainer').innerHTML   = '';
                data.forEach(item => addStep(item.role_verifikator));
                openModal();
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat memuat data alur.', confirmButtonColor: '#3b82f6' });
            });
    }

    function confirmDelete(jenis) {
        Swal.fire({
            title: 'Hapus Alur?',
            html: `Alur verifikasi untuk <strong>${jenis}</strong> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) {
                const forms = document.querySelectorAll('[id^="delete-form-"]');
                forms.forEach(f => {
                    if (f.action.includes(encodeURIComponent(jenis)) || f.action.includes(jenis)) {
                        f.submit();
                    }
                });
            }
        });
    }
</script>
@endpush

</x-master>
