<x-app-layout>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <div class="flex">

            <!-- SIDEBAR -->
            <aside class="w-64 min-h-screen bg-white dark:bg-gray-800 shadow-md">

                <!-- BRAND -->
                <div class="px-5 py-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-[#19183B] flex items-center justify-center text-white text-lg shadow-sm">
                            📅
                        </div>

                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-lg font-bold text-gray-800 dark:text-white">
                                    Book & Fix
                                </h1>

                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md bg-gray-100 text-gray-600">
                                    ADMIN
                                </span>
                            </div>

                            <p class="text-xs text-gray-400 mt-0.5">
                                Campus Facility Management
                            </p>
                        </div>

                    </div>
                </div>

                <!-- NAVIGATION -->
                <nav class="px-4 py-5">

                    <p class="px-3 mb-4 text-[11px] font-medium tracking-wide text-[#708993] uppercase">
                        Menu Utama
                    </p>

                    <!-- Dashboard -->
                    <a href="{{ route('admin') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#708993] hover:bg-[#F4F8F7] hover:text-[#19183B] transition">
                        <span class="text-lg">🏠</span>
                        <span class="text-sm">Dashboard</span>
                    </a>

                    <!-- Fasilitas -->
                    <a href="{{ route('admin.facilities.index') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl text-[#708993] hover:bg-[#F4F8F7] hover:text-[#19183B] transition">
                        <span class="text-lg">🏢</span>
                        <span class="text-sm">Fasilitas</span>
                    </a>

                    <!-- Pengguna -->
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl text-[#708993] hover:bg-[#F4F8F7] hover:text-[#19183B] transition">
                        <span class="text-lg">👤</span>
                        <span class="text-sm">Pengguna</span>
                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('admin.rekap') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl bg-[#19183B] text-white font-semibold">
                        <span class="text-lg">📊</span>
                        <span class="text-sm">Laporan</span>
                    </a>

                </nav>

            </aside>


            <!-- CONTENT -->
            <main class="flex-1 p-8">

                <!-- HEADER -->
                <div class="mb-8">

                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                        Rekap Penggunaan Fasilitas
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Lihat penggunaan fasilitas berdasarkan periode tertentu.
                    </p>

                </div>


                <!-- REKAP -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">

                    <div class="p-6">

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                            Rekap Penggunaan
                        </h3>


                        <!-- FILTER PERIODE -->
                        <form method="GET" action="{{ route('admin.rekap') }}" class="mb-6">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                                <!-- TANGGAL MULAI -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal Mulai
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_mulai"
                                        value="{{ $tanggalMulai ?? '' }}"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    >
                                </div>


                                <!-- TANGGAL AKHIR -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal Akhir
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_akhir"
                                        value="{{ $tanggalAkhir ?? '' }}"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    >
                                </div>


                                <!-- BUTTON -->
                                <div class="flex gap-2">

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-[#19183B] text-white rounded-lg hover:opacity-90 transition">
                                        Filter
                                    </button>

                                    <a
                                        href="{{ route('admin.rekap') }}"
                                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>


                        <!-- TABEL -->
                        <div class="overflow-x-auto">

                            <table class="w-full text-sm text-left">

                                <thead>
                                    <tr class="border-b dark:border-gray-700">

                                        <th class="px-4 py-3">
                                            No
                                        </th>

                                        <th class="px-4 py-3">
                                            Fasilitas
                                        </th>

                                        <th class="px-4 py-3">
                                            Lokasi
                                        </th>

                                        <th class="px-4 py-3">
                                            Jumlah Penggunaan
                                        </th>

                                    </tr>
                                </thead>


                                <tbody>

                                    @forelse ($rekap as $index => $data)

                                        <tr class="border-b dark:border-gray-700">

                                            <td class="px-4 py-3">
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">
                                                {{ $data->name }}
                                            </td>

                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                                {{ $data->location }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $data->jumlah_penggunaan }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                                Belum ada data penggunaan fasilitas.
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>