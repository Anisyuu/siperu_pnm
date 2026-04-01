<x-master>

        <div class="bg-slate-100 min-h-screen px-8 py-10">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-8 flex-wrap gap-4">

            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Kelola Pengguna
                </h1>

                <p class="text-slate-500 mt-1 text-sm">
                    Manajemen seluruh pengguna sistem
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">

                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-tags text-blue-500 text-sm"></i>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Total Pengguna</div>
                        <div class="text-lg font-bold text-slate-800">
                            {{ $users->count() }}
                        </div>
                    </div>

                </div>

                <a href="{{ route('kasubag.tambah-user') }}" class="px-5 py-5 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
                    <i class="fa-solid fa-plus text-sm"></i>
                </a>

            </div>
        </div>

    <div class="max-w-7xl mx-auto flex flex-col gap-6">

        <!-- Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-3 items-center">

        <form method="GET" action="{{ route('kasubag.list-user') }}" class="flex flex-col md:flex-row gap-3 w-full">

            <!-- Search -->
            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau email..."
                class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
            />

            <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg hover:brightness-110 transition"> Cari </button>

            <!-- Status Filter -->
            <select
                name="status"
                class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
            >
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            <!-- Button -->
            <button
                type="submit"
                class="px-5 py-2 bg-primary text-white rounded-lg hover:brightness-110 transition"
            >
                Filter
            </button>

        </form>

                <button class="px-4 py-2 text-sm font-medium rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Export
                </button>

            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 text-text-main uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">No</th>
                            <th class="px-6 py-4 text-left">User</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Nomor Induk</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border-subtle dark:divide-gray-700">
                        <!-- Row -->

                        @forelse ( $users as $user )
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                            <td class="px-6 py-4 text-text-secondary">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <i class="fa-solid fa-users text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-text-main dark:text-white">
                                        {{ $user->nama_lengkap }}
                                    </p>
                                    <p class="text-xs text-text-secondary">
                                        {{ $user->roles->first()->nama ?? 'User' }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4 text-text-secondary">
                                {{ $user->nomor_induk }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($user->is_active == 'active')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-900/40 dark:text-green-300">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                                        Inactive
                                    </span>
                                @endif
                            </td>



                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-4 text-text-secondary">

                                    <a href="{{ route('kasubag.detail-user', $user->nomor_induk) }}"
                                     class="w-8 h-8 flex items-center justify-center bg-blue-200/40 border border-blue-300 text-blue-500 rounded-lg hover:bg-blue-300/50 hover:border-blue-400 transition-all">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>

                                    <form action="{{ route('kasubag.edit-user', $user->nomor_induk) }}" method="GET" class="inline">
                                        @csrf
                                        <button type="submit"
                                         class="w-8 h-8 flex items-center justify-center bg-orange-200/40 border border-orange-300 text-orange-500 rounded-lg  hover:bg-orange-300/50 hover:border-orange-400 transition-all">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                        @empty

                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>

        <!-- Pagination -->
        {{-- <div class="flex items-center justify-between">

            <button class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                Previous
            </button>

            <div class="flex items-center gap-2">
                <button class="px-3 py-1 bg-primary text-white rounded-md text-sm shadow-sm">
                    1
                </button>
                <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                    2
                </button>
                <button class="px-3 py-1 border border-border-subtle dark:border-gray-600 rounded-md text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                    3
                </button>
            </div>

            <button class="px-4 py-2 rounded-lg border border-border-subtle dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                Next
            </button>

        </div> --}}

        <!-- Pagination -->
<div class="mt-6">
    {{ $users->links() }}
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
