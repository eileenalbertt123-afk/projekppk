<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Rekap Penggunaan Fasilitas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                        Rekap Penggunaan
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Fasilitas</th>
                                    <th class="px-4 py-3">Lokasi</th>
                                    <th class="px-4 py-3">Jumlah Penggunaan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($rekap as $index => $data)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $data->name }}
                                        </td>

                                        <td class="px-4 py-3">
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

        </div>
    </div>
</x-app-layout>