<x-master>
<div class="min-h-screen bg-slate-100 px-6 py-10">
<div class="max-w-3xl mx-auto flex flex-col gap-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-slate-900 text-3xl font-extrabold tracking-tight">
                Edit Pengguna
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Perbarui data pengguna yang sudah ada di dalam sistem
            </p>
        </div>
        {{-- <a href="{{ route('kasubag.list-user') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 text-sm text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition self-start md:self-auto">
            <i class="fa-solid fa-arrow-left text-slate-400 text-xs"></i>
            Kembali
        </a> --}}
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/40">
            <p class="text-sm font-bold text-slate-700">Informasi Pengguna</p>
        </div>

        <form action="{{ route('kasubag.update-user', $user->nomor_induk) }}" method="POST" class="px-6 py-6 flex flex-col gap-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nama Lengkap --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    >
                </div>

                {{-- Nomor Telepon --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor Telepon</label>
                    <input
                        type="text"
                        name="no_telp"
                        value="{{ old('no_telp', $user->no_telp) }}"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    >
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    >
                </div>

                {{-- Role --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Role</label>
                    <select
                        name="role"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    >
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->nama }}" {{ old('role', $user->roles->first()->nama ?? '') == $role->nama ? 'selected' : '' }}>
                                {{ ucfirst($role->nama) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <select
                        name="is_active"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:outline-none text-slate-700 transition"
                    >
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('is_active', $user->is_active) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('is_active', $user->is_active) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('kasubag.list-user') }}"
                   class="px-5 py-2.5 border border-slate-200 text-sm text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:brightness-110 active:scale-95 transition shadow-sm shadow-blue-200">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
</div>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
        });
    </script>
@endif

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

</x-master>
