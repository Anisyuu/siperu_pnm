<x-master>
    <div class="max-w-3xl mx-auto p-10 bg-white rounded-2xl border border-gray-200 shadow-sm">

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-text-main">
                Detail User
            </h2>
            <p class="text-sm text-text-secondary mt-1">
                Informasi lengkap pengguna di dalam sistem
            </p>
        </div>

        <!-- Detail -->
        <div class="flex flex-col gap-6">

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-text-main">
                    {{ $user->nama_lengkap }}
                </div>
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-text-main">
                    {{ $user->nomor_telepon ?? '-' }}
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold mb-2">Email</label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-text-main">
                    {{ $user->email }}
                </div>
            </div>

            <!-- Nomor Induk -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nomor Induk</label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-text-main">
                    {{ $user->nomor_induk }}
                </div>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold mb-2">Role</label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-text-main">
                    {{ ucfirst($user->roles->first()->nama ?? '-') }}
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold mb-2">Status</label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-text-main">
                    @if ($user->is_active == 'active')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                            Active
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

        </div>

        <!-- Button -->
        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('kasubag.list-user') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                Kembali
            </a>

            <a href="{{ route('kasubag.edit-user', $user->nomor_induk) }}"
               class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:brightness-110 transition">
                Edit User
            </a>
        </div>

    </div>

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
