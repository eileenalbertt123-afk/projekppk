<x-app-layout>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <div class="flex">

            <!-- SIDEBAR -->
            <aside class="w-64 min-h-screen bg-white dark:bg-gray-800 shadow-md">

                <div class="p-6 border-b dark:border-gray-700">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">
                        Admin Panel
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Sistem Reservasi Fasilitas
                    </p>
                </div>

                <nav class="p-4 space-y-2">

                    <a href="{{ route('admin') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg bg-indigo-50 text-indigo-600 font-semibold">
                        <span>🏠</span>
                        Dashboard
                    </a>

                    <a href="{{ route('facilities.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <span>🏢</span>
                        Fasilitas
                    </a>

                    <a href="#pengguna"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <span>👤</span>
                        Pengguna
                    </a>

                    <a href="#laporan"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <span>📊</span>
                        Laporan
                    </a>

                </nav>

            </aside>


            <!-- CONTENT -->
            <main class="flex-1 p-8">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-8">

                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                            Dashboard Admin
                        </h2>

                        <p class="text-gray-500 mt-1">
                            Kelola pengguna, fasilitas, dan laporan sistem.
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-gray-800 dark:text-white">
                            Admin
                        </p>
                        <p class="text-sm text-gray-500">
                            Administrator
                        </p>
                    </div>

                </div>


                <!-- STATISTIC CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

                    <!-- FASILITAS -->
                    <a href="{{ route('facilities.index') }}"
                       class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Total Fasilitas
                                </p>

                                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                                    {{ $totalFasilitas }}
                                </p>
                            </div>

                            <div class="text-3xl bg-indigo-100 p-3 rounded-lg">
                                🏢
                            </div>

                        </div>

                        <p class="text-sm text-indigo-600 mt-4 group-hover:underline">
                            Kelola fasilitas →
                        </p>

                    </a>

                    <!-- FASILITAS AKTIF -->
                    <a href="{{ route('facilities.index') }}"
                       class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Fasilitas Aktif
                                </p>

                                <p class="text-3xl font-bold text-green-600 mt-2">
                                    {{ $fasilitasAktif }}
                                </p>
                            </div>

                            <div class="text-3xl bg-green-100 p-3 rounded-lg">
                                ✓
                            </div>

                        </div>

                        <p class="text-sm text-green-600 mt-4">
                            Fasilitas dapat digunakan
                        </p>

                    </a>

                    <!-- VERIFIKASI -->
                    <a href="#pengguna"
                       class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Menunggu Verifikasi
                                </p>

                                <p class="text-3xl font-bold text-orange-500 mt-2">
                                    5
                                </p>
                            </div>

                            <div class="text-3xl bg-orange-100 p-3 rounded-lg">
                                👤
                            </div>

                        </div>

                        <p class="text-sm text-orange-600 mt-4 group-hover:underline">
                            Periksa pengguna →
                        </p>

                    </a>

                    <!-- KERUSAKAN -->
                    <a href="#laporan"
                       class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Laporan Kerusakan
                                </p>

                                <p class="text-3xl font-bold text-red-500 mt-2">
                                    3
                                </p>
                            </div>

                            <div class="text-3xl bg-red-100 p-3 rounded-lg">
                                🔧
                            </div>

                        </div>

                        <p class="text-sm text-red-600 mt-4 group-hover:underline">
                            Lihat laporan →
                        </p>

                    </a>

                </div>

                <!-- QUICK ACTION -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8">

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        Aksi Cepat
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <a href="{{ route('facilities.index') }}"
                           class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">

                            <p class="font-semibold text-gray-800 dark:text-white">
                                + Kelola Fasilitas
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Tambah, ubah, atau nonaktifkan fasilitas.
                            </p>

                        </a>

                        <a href="#pengguna"
                           class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-orange-50 dark:hover:bg-gray-700 transition">

                            <p class="font-semibold text-gray-800 dark:text-white">
                                ✓ Verifikasi Pengguna
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Periksa pengguna yang menunggu verifikasi.
                            </p>

                        </a>

                        <a href="{{ route('admin.rekap') }}"
                            class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-green-50 dark:hover:bg-gray-700 transition">

                            <p class="font-semibold text-gray-800 dark:text-white">
                                📊 Lihat Rekap
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Lihat penggunaan dan kerusakan fasilitas.
                            </p>

                        </a>

                    </div>

                </div>

                <!-- PENGGUNA -->
                <div id="pengguna"
                     class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8">

                    <div class="flex items-center justify-between mb-5">

                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                Pengguna Menunggu Verifikasi
                            </h3>

                            <p class="text-sm text-gray-500">
                                Pengguna yang perlu diperiksa oleh admin.
                            </p>
                        </div>

                        <span class="px-3 py-1 text-sm rounded-full bg-orange-100 text-orange-600">
                            5 pengguna
                        </span>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>
                                <tr class="border-b dark:border-gray-700 text-left">
                                    <th class="py-3">Nama</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-right">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr class="border-b dark:border-gray-700">

                                    <td class="py-4 font-medium">
                                        Pengguna 1
                                    </td>

                                    <td class="py-4 text-gray-500">
                                        pengguna@email.com
                                    </td>

                                    <td>
                                        <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600">
                                            Menunggu
                                        </span>
                                    </td>

                                    <td class="text-right">
                                        <button
                                            class="px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                            Periksa
                                        </button>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- LAPORAN -->
                <div id="laporan"
                     class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- PENGGUNAAN -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">

                        <div class="flex justify-between items-center mb-5">

                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                    Rekap Penggunaan
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Penggunaan fasilitas bulan ini.
                                </p>
                            </div>

                            <span class="text-2xl">
                                📊
                            </span>

                        </div>

                        <div class="space-y-4">

                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Lab Komputer</span>
                                    <span>32 penggunaan</span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full w-4/5"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Ruang Seminar</span>
                                    <span>21 penggunaan</span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full w-3/5"></div>
                                </div>
                            </div>

                        </div>

                        <button class="mt-6 w-full py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                            Lihat Rekap Lengkap
                        </button>

                    </div>

                    <!-- KERUSAKAN -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">

                        <div class="flex justify-between items-center mb-5">

                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                    Rekap Kerusakan
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Frekuensi kerusakan fasilitas.
                                </p>
                            </div>

                            <span class="text-2xl">
                                🔧
                            </span>

                        </div>

                        <div class="space-y-4">

                            <div class="flex justify-between items-center">
                                <span>Lab Komputer</span>
                                <span class="font-bold text-red-500">
                                    5 kali
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span>Ruang Seminar</span>
                                <span class="font-bold text-orange-500">
                                    2 kali
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span>Lapangan</span>
                                <span class="font-bold text-red-500">
                                    7 kali
                                </span>
                            </div>

                        </div>

                        <button class="mt-6 w-full py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50 transition">
                            Lihat Rekap Kerusakan
                        </button>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>