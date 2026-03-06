<x-master>

<div class="max-w-7xl mx-auto flex flex-col gap-8 p-10 rounded-2xl bg-white/80 border-2 border-gray-200">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <h2 class="text-text-main dark:text-white text-3xl font-extrabold tracking-tight">
                Kelola Ruangan
            </h2>

            <p class="text-text-secondary text-sm mt-1">
                Manajemen data ruangan kampus
            </p>
        </div>

        <a href="{{ route('kasubag.tambah-ruangan') }}"
            class="px-5 py-2 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
            + Tambah Ruangan
        </a>

    </div>


    <!-- ================= FILTER ================= -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 p-4 shadow-sm">

        <div class="flex flex-col md:flex-row gap-3 items-center">

        <form method="GET" action="{{ route('kasubag.kelola-ruangan') }}" class="flex flex-col md:flex-row gap-3 w-full">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama ruangan..."
                class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none"
            />

            <button
                type="submit"
                class="px-5 py-2 bg-primary text-white rounded-lg hover:brightness-110 transition">
                Cari
            </button>

            <!-- Filter Gedung -->
            <select
                name="gedung"
                class="px-4 py-2 text-sm rounded-lg border border-border-subtle dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary focus:outline-none text-text-main dark:text-white"
            >
                <option value="">Semua Gedung</option>
                @foreach ($gedung as $g)
                    <option value="{{ $g->id }}" {{ request('gedung') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach
            </select>

            <!-- Submit -->
            <button
                type="submit"
                class="h-10 px-6 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:brightness-110 transition"
            >
                Terapkan
            </button>
    </form>

        </div>

    </div>


    <!-- ================= TABLE ================= -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle dark:border-gray-700 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <!-- HEAD -->
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-border-subtle dark:border-gray-700 text-text-main uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Gedung</th>
                        <th class="px-6 py-4 text-left">Lantai</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>


                <!-- BODY -->
                <tbody class="divide-y divide-border-subtle dark:divide-gray-700">

                    @foreach ( $ruangan as $ruang )
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <i class="fa-solid fa-door-open text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-text-main dark:text-white">
                                        {{ $ruang->nama_ruang }}
                                    </p>
                                    <p class="text-xs text-text-secondary">
                                        {{ $ruang->jenisRuangan->nama }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-text-secondary">
                                {{ $ruang->gedung->nama }}
                            </td>
                            <td class="px-6 py-4 text-text-secondary">
                                Lantai {{ $ruang->lantai }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-4 text-text-secondary">

                                    <button class="hover:text-primary transition">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    <a href="{{ route('kasubag.edit-ruangan', $ruang->id) }}" class="hover:text-yellow-500 transition">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <button class="hover:text-red-500 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>

            </table>

        </div>

    </div>


    <!-- ================= PAGINATION ================= -->
    <div class="mt-6">
    {{ $ruangan->links() }}
    </div>

</div>

</x-master>
