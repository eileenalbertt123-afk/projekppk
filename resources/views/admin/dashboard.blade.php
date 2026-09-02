<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold mb-2">
                        Selamat Datang, Admin
                    </h3>

                    <p class="mb-6">
                        Kelola pengguna, fasilitas, dan laporan melalui halaman admin.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <a href="#"
                           class="p-5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-bold">Kelola Fasilitas</h4>
                            <p class="text-sm mt-2">
                                Tambah, edit, dan nonaktifkan fasilitas.
                            </p>
                        </a>

                        <a href="#"
                           class="p-5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-bold">Verifikasi Pengguna</h4>
                            <p class="text-sm mt-2">
                                Verifikasi akun pengguna yang mendaftar.
                            </p>
                        </a>

                        <a href="#"
                           class="p-5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-bold">Rekap Fasilitas</h4>
                            <p class="text-sm mt-2">
                                Lihat dan ekspor data fasilitas.
                            </p>
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>