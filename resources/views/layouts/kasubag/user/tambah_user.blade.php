<x-master>
    <div class="max-w-3xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm">

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-text-main">
                Tambah User
            </h2>
            <p class="text-sm text-text-secondary mt-1">
                Tambahkan pengguna baru ke dalam sistem
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('kasubag.simpan-user') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                >
            </div>

            <!-- Nomor Induk -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nomor Induk</label>
                <input
                    type="text"
                    name="nomor_induk"
                    value="{{ old('nomor_induk') }}"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                >
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold mb-2">Role</label>
                <select
                    name="role"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                >
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->nama }}" {{ old('role') == $role->nama ? 'selected' : '' }}>
                            {{ ucfirst($role->nama) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('kasubag.list-user') }}"
                   class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110 transition">
                    Simpan User
                </button>
            </div>

        </form>

    </div>

    <!-- SweetAlert CDN -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <!-- Error Handling -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
            });
        </script>
    @endif

    <!-- Success Message -->
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
