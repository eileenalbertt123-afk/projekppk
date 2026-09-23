<x-app-layout>

    <div class="min-h-screen bg-[#F4F8F7]">

        <div class="flex min-h-screen">

            <!-- SIDEBAR -->
            <aside class="w-64 min-h-screen bg-white shadow-md flex-shrink-0">

                <!-- BRAND -->
                <div class="px-5 py-5 border-b border-gray-200">
                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-[#19183B] flex items-center justify-center text-white text-lg shadow-sm">
                            📅
                        </div>

                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-lg font-bold text-gray-800">
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
                        class="flex items-center gap-3 px-4 py-3 rounded-xl
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">
                        <span class="text-lg">🏠</span>
                        <span class="text-sm">Dashboard</span>
                    </a>

                    <!-- Fasilitas -->
                    <a href="{{ route('admin.facilities.index') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               bg-[#19183B] text-white font-semibold">
                        <span class="text-lg">🏢</span>
                        <span class="text-sm">Fasilitas</span>
                    </a>

                    <!-- Pengguna -->
                    <a href="#pengguna"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">
                        <span class="text-lg">👤</span>
                        <span class="text-sm">Pengguna</span>
                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('admin.rekap') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">
                        <span class="text-lg">📊</span>
                        <span class="text-sm">Laporan</span>
                    </a>

                </nav>

            </aside>


            <!-- CONTENT -->
            <main class="flex-1 p-8">

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">

                    <div>
                        <h1 class="text-2xl font-bold text-[#19183B]">
                            Kelola Fasilitas
                        </h1>

                        <p class="mt-1 text-sm text-[#708993]">
                            Kelola data fasilitas yang tersedia di kampus
                        </p>
                    </div>

                    <a href="{{ route('admin.facilities.create') }}"
                        class="px-4 py-2.5 rounded-lg bg-[#19183B]
                               text-white text-sm font-semibold
                               hover:opacity-90 transition">
                        + Tambah Fasilitas
                    </a>

                </div>


                <!-- Table -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-[#F4F8F7]">

                                <tr class="text-left text-[#708993]">

                                    <th class="px-6 py-4 font-semibold">
                                        No
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Fasilitas
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Jenis
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Lokasi
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Kapasitas
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 font-semibold">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @forelse ($fasilitas as $item)

                                    <tr class="hover:bg-gray-50">

                                        <!-- No -->
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $loop->iteration }}
                                        </td>


                                        <!-- Fasilitas -->
                                        <td class="px-6 py-4">

                                            <p class="font-semibold text-[#19183B]">
                                                {{ $item->name }}
                                            </p>

                                            @if($item->description)

                                                <p class="mt-1 text-xs text-[#708993]">
                                                    {{ $item->description }}
                                                </p>

                                            @endif

                                        </td>


                                        <!-- Jenis -->
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $item->type }}
                                        </td>


                                        <!-- Lokasi -->
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $item->location }}
                                        </td>


                                        <!-- Kapasitas -->
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $item->capacity }} orang
                                        </td>


                                        <!-- Status -->
                                        <td class="px-6 py-4">

                                            @if($item->status === 'tersedia')

                                                <span class="inline-flex px-3 py-1 rounded-full
                                                             bg-[#A1C2BD] text-[#19183B]
                                                             text-xs font-semibold">
                                                    Tersedia
                                                </span>

                                            @elseif($item->status === 'dalam_perbaikan')

                                                <span class="inline-flex px-3 py-1 rounded-full
                                                             bg-yellow-100 text-yellow-700
                                                             text-xs font-semibold">
                                                    Dalam Perbaikan
                                                </span>

                                            @else

                                                <span class="inline-flex px-3 py-1 rounded-full
                                                             bg-gray-100 text-gray-500
                                                             text-xs font-semibold">
                                                    Nonaktif
                                                </span>

                                            @endif

                                        </td>


                                        <!-- Aksi -->
                                        <td class="px-6 py-4">

                                            <div class="flex items-center gap-2">

                                                <!-- Edit -->
                                                <a href="{{ route('admin.facilities.edit', $item->id) }}"
                                                    class="px-3 py-1.5 rounded-lg border border-gray-200
                                                           text-xs font-medium text-[#19183B]
                                                           hover:bg-[#F4F8F7]">
                                                    Edit
                                                </a>


                                                <!-- Nonaktifkan -->
                                                @if($item->status === 'tersedia')

                                                    <form action="{{ route('admin.facilities.deactivate', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menonaktifkan fasilitas ini?')">

                                                        @csrf
                                                        @method('PUT')

                                                        <button type="submit"
                                                            class="px-3 py-1.5 rounded-lg
                                                                   text-xs font-medium
                                                                   text-red-600 hover:bg-red-50">
                                                            Nonaktifkan
                                                        </button>

                                                    </form>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td colspan="7"
                                            class="px-6 py-10 text-center text-[#708993]">
                                            Belum ada data fasilitas.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>