<x-master>

<div class="max-w-7xl mx-auto flex flex-col gap-8 p-10 rounded-2xl bg-white/80 border-2 border-gray-200">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-text-main dark:text-white">
                Kelola Ruangan
            </h2>

            <p class="text-sm text-text-secondary mt-1">
                Manajemen data ruangan kampus
            </p>
        </div>

        <a href="#"
            class="px-5 py-2 bg-primary text-white rounded-lg shadow-sm hover:brightness-110 transition">
            + Tambah Ruangan
        </a>

    </div>


    <!-- ================= FILTER ================= -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-border-subtle p-4 shadow-sm">

        <div class="flex flex-col md:flex-row gap-3">

            <input
                type="text"
                placeholder="Cari nama ruangan..."
                class="flex-1 px-4 py-2 text-sm rounded-lg border border-border-subtle focus:ring-2 focus:ring-primary focus:outline-none"
            />

            <select class="px-4 py-2 text-sm rounded-lg border border-border-subtle">
                <option>Semua Gedung</option>
                <option>Gedung A</option>
                <option>Gedung B</option>
            </select>

            <select class="px-4 py-2 text-sm rounded-lg border border-border-subtle">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Maintenance</option>
                <option>Nonaktif</option>
            </select>

        </div>

    </div>


    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-xl border border-border-subtle shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <!-- TABLE HEAD -->
                <thead class="bg-gray-50 border-b border-border-subtle uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Gedung</th>
                        <th class="px-6 py-4 text-left">Lantai</th>
                        <th class="px-6 py-4 text-left">Kapasitas</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>


                <!-- TABLE BODY -->
                <tbody class="divide-y divide-border-subtle">

                    <!-- ROW 1 -->
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 flex items-center gap-4">

                            <img
                                src="https://picsum.photos/60"
                                class="w-12 h-12 rounded-lg object-cover border"
                            />

                            <div>
                                <p class="font-semibold text-text-main">
                                    Aula Utama
                                </p>

                                <p class="text-xs text-text-secondary">
                                    Ruang Aula Serbaguna
                                </p>
                            </div>

                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Gedung Rektorat
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Lantai 1
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            200 Orang
                        </td>

                        <td class="px-6 py-4">

                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                                Aktif
                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-4 text-gray-500">

                                <button class="hover:text-primary transition">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                                <button class="hover:text-yellow-500 transition">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button class="hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    <!-- ROW 2 -->
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 flex items-center gap-4">

                            <img
                                src="https://picsum.photos/61"
                                class="w-12 h-12 rounded-lg object-cover border"
                            />

                            <div>
                                <p class="font-semibold text-text-main">
                                    Lab Komputer 1
                                </p>

                                <p class="text-xs text-text-secondary">
                                    Laboratorium Komputer
                                </p>
                            </div>

                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Gedung Teknik
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            Lantai 2
                        </td>

                        <td class="px-6 py-4 text-text-secondary">
                            40 Orang
                        </td>

                        <td class="px-6 py-4">

                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600">
                                Maintenance
                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-4 text-gray-500">

                                <button class="hover:text-primary transition">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                                <button class="hover:text-yellow-500 transition">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button class="hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- ================= PAGINATION ================= -->
        <div class="flex justify-between items-center px-6 py-4 border-t">

            <p class="text-sm text-gray-500">
                Menampilkan 1 - 10 dari 50 data
            </p>

            <div class="flex gap-2">

                <button class="px-3 py-1 border rounded-md hover:bg-gray-100">
                    Prev
                </button>

                <button class="px-3 py-1 bg-primary text-white rounded-md">
                    1
                </button>

                <button class="px-3 py-1 border rounded-md hover:bg-gray-100">
                    2
                </button>

                <button class="px-3 py-1 border rounded-md hover:bg-gray-100">
                    Next
                </button>

            </div>

        </div>

    </div>

</div>

</x-master>
