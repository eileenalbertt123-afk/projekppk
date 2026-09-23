<x-app-layout>

    <div class="min-h-screen bg-[#F4F8F7]">

        <div class="flex min-h-screen">

            <!-- SIDEBAR -->
            <aside class="w-64 min-h-screen bg-white shadow-md flex-shrink-0">

                <!-- Brand -->
                <div class="px-6 py-6">
                    <h1 class="text-xl font-bold text-[#19183B]">
                        Book & Fix
                    </h1>

                    <p class="text-xs text-[#708993] mt-1">
                        Admin Panel
                    </p>
                </div>

                <!-- Navigation -->
                <nav class="px-4">

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
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">

                        <span class="text-lg">🏢</span>
                        <span class="text-sm">Fasilitas</span>

                    </a>

                    <!-- Pengguna -->
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               bg-[#19183B] text-white font-semibold">

                        <span class="text-lg">👥</span>
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
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-[#19183B]">
                        Kelola Pengguna
                    </h1>

                    <p class="mt-1 text-sm text-[#708993]">
                        Kelola akun pengguna dalam sistem
                    </p>
                </div>


                <!-- Alert -->
                @if(session('success'))
                    <div class="mb-5 rounded-lg bg-green-100 border border-green-200
                                px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif


                <!-- Table -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-[#F4F8F7]">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold text-[#19183B]">
                                        Nama
                                    </th>

                                    <th class="px-6 py-4 text-left font-semibold text-[#19183B]">
                                        Email
                                    </th>

                                    <th class="px-6 py-4 text-left font-semibold text-[#19183B]">
                                        Tipe Pengguna
                                    </th>

                                    <th class="px-6 py-4 text-left font-semibold text-[#19183B]">
                                        Role
                                    </th>

                                    <th class="px-6 py-4 text-left font-semibold text-[#19183B]">
                                        Status Akun
                                    </th>

                                    <th class="px-6 py-4 text-left font-semibold text-[#19183B]">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">

                                @forelse($pengguna as $item)

                                    <tr class="hover:bg-gray-50">

                                        <!-- Nama -->
                                        <td class="px-6 py-4 font-medium text-[#19183B]">
                                            {{ $item->name }}
                                        </td>

                                        <!-- Email -->
                                        <td class="px-6 py-4 text-[#708993]">
                                            {{ $item->email }}
                                        </td>

                                        <!-- Tipe Pengguna -->
                                        <td class="px-6 py-4 text-[#708993]">
                                            @if($item->userType)
                                                {{ ucfirst($item->userType->name) }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <!-- Role -->
                                        <td class="px-6 py-4">
                                            @if($item->role === 'admin')
                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                             bg-purple-100 text-purple-700">
                                                    Admin
                                                </span>
                                            @elseif($item->role === 'petugas')
                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                             bg-blue-100 text-blue-700">
                                                    Petugas
                                                </span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                             bg-gray-100 text-gray-700">
                                                    Pengguna
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">

                                            @if($item->status_akun === 'aktif')

                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                             bg-green-100 text-green-700">
                                                    Aktif
                                                </span>

                                            @else

                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                             bg-gray-100 text-gray-700">
                                                    Nonaktif
                                                </span>

                                            @endif

                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-6 py-4">

                                            <form
                                                action="{{ route('admin.pengguna.status', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin mengubah status akun ini?')">

                                                @csrf
                                                @method('PUT')

                                                @if($item->status_akun === 'aktif')

                                                    <input
                                                        type="hidden"
                                                        name="status_akun"
                                                        value="nonaktif">

                                                    <button
                                                        type="submit"
                                                        class="text-sm font-medium text-red-600
                                                               hover:text-red-800">
                                                        Nonaktifkan
                                                    </button>

                                                @else

                                                    <input
                                                        type="hidden"
                                                        name="status_akun"
                                                        value="aktif">

                                                    <button
                                                        type="submit"
                                                        class="text-sm font-medium text-green-600
                                                               hover:text-green-800">
                                                        Aktifkan
                                                    </button>

                                                @endif

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-10 text-center text-sm text-[#708993]">
                                            Belum ada data pengguna.
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