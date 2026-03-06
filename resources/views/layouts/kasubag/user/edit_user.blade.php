<x-master>
    <div class="max-w-3xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm">

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-text-main">
                Edit User
            </h2>
            <p class="text-sm text-text-secondary mt-1">
                Edit pengguna yang sudah ada di dalam sistem
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('kasubag.update-user', $user->nomor_induk) }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
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
                        <option value="{{ $role->nama }}" {{ old('role', $user->roles->first()->nama ?? '') == $role->nama ? 'selected' : '' }}>
                            {{ ucfirst($role->nama) }}
                        </option>
                    @endforeach
                </select>
            </div>

             <div>
                <label class="block text-sm font-semibold mb-2">Status</label>
                <select
                    name="is_active"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                >
                    <option value="">-- Pilih Status --</option>
                    <option value="active" {{ old('is_active', $user->is_active) == 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive" {{ old('is_active', $user->is_active) == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
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
