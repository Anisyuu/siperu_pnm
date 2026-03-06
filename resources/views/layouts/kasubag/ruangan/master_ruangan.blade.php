<x-master>

<div class="max-w-7xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm space-y-8">

<!-- HEADER -->
<div>
    <h2 class="text-3xl font-extrabold text-text-main">
        Master Ruangan
    </h2>
    <p class="text-sm text-text-secondary mt-1">
        Kelola data gedung dan jenis ruangan
    </p>
</div>


<div class="grid lg:grid-cols-2 gap-6">

{{-- ================= GEDUNG ================= --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

    <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <h3 class="font-semibold text-text-main">
            Daftar Gedung
        </h3>

        <button onclick="openModal('gedungModal')"
            class="size-10 bg-primary text-white rounded-lg flex items-center justify-center shadow hover:brightness-110 transition">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <div class="p-6">
        <table class="w-full text-sm">

            <thead>
                <tr class="text-text-secondary uppercase text-xs">
                    <th class="pb-3 text-left">Nama Gedung</th>
                    <th class="pb-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach($gedung as $g)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 font-medium text-text-main">
                        {{ $g->nama }}
                    </td>

                    <td class="py-3 text-right">
                        <form action="{{ route('kasubag.hapus-gedung', $g->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                class="px-3 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

</div>



{{-- ================= JENIS RUANG ================= --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

    <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <h3 class="font-semibold text-text-main">
            Jenis Ruangan
        </h3>

        <button onclick="openModal('jenisModal')"
            class="size-10 bg-primary text-white rounded-lg flex items-center justify-center shadow hover:brightness-110 transition">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <div class="p-6">
        <table class="w-full text-sm">

            <thead>
                <tr class="text-text-secondary uppercase text-xs">
                    <th class="pb-3 text-left">Nama Jenis Ruangan</th>
                    <th class="pb-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach($jenisRuangan as $j)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 font-medium text-text-main">
                        {{ $j->nama }}
                    </td>

                    <td class="py-3 text-right">
                        <form action="{{ route('kasubag.hapus-jenis-ruangan', $j->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                class="px-3 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

</div>

</div>
</div>



{{-- ================= MODAL GEDUNG ================= --}}
<div id="gedungModal"
class="fixed inset-0 hidden bg-black/40 flex items-center justify-center z-50">

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm w-full max-w-md p-6 space-y-6">

<h3 class="text-lg font-bold text-text-main">
    Tambah Gedung
</h3>

<form method="POST" action="{{ route('kasubag.simpan-gedung') }}" class="space-y-4">
@csrf

<div>
<label class="block text-sm font-semibold mb-2">Nama Gedung</label>
<input name="nama" required
class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none">
</div>

<div>
<label class="block text-sm font-semibold mb-2">Penanggung Jawab</label>
<select name="id_user" required
class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none">
<option value="">-- Pilih Penanggung Jawab --</option>
@foreach($user as $usr)
<option value="{{ $usr->nomor_induk }}">
{{ $usr->nama_lengkap }}
</option>
@endforeach
</select>
</div>

<div class="flex justify-end gap-3 pt-2">
<button type="button" onclick="closeModal('gedungModal')"
class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
Batal
</button>

<button type="submit"
class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110 transition">
Simpan
</button>
</div>

</form>

</div>
</div>



{{-- ================= MODAL JENIS ================= --}}
<div id="jenisModal"
class="fixed inset-0 hidden bg-black/40 flex items-center justify-center z-50">

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm w-full max-w-md p-6 space-y-6">

<h3 class="text-lg font-bold text-text-main">
    Tambah Jenis Ruangan
</h3>

<form method="POST" action="{{ route('kasubag.simpan-jenis-ruangan') }}" class="space-y-4">
@csrf

<div>
<label class="block text-sm font-semibold mb-2">Nama Jenis Ruangan</label>
<input name="nama" required
class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none">
</div>

<div class="flex justify-end gap-3 pt-2">
<button type="button" onclick="closeModal('jenisModal')"
class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
Batal
</button>

<button type="submit"
class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110 transition">
Simpan
</button>
</div>

</form>

</div>
</div>



<script>
function openModal(id){
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
}

function closeModal(id){
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
}
</script>

</x-master>
