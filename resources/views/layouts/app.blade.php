<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine JS untuk buka-tutup sidebar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex relative overflow-x-hidden">

    <!-- 1. SIDEBAR (Bisa Buka-Tutup) -->
    <aside 
        x-show="sidebarOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col justify-between p-4 fixed md:static inset-y-0 left-0 z-50 h-screen">
        
        <div>
            <!-- Header Sidebar & Tombol Sembunyi -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-700 mb-6">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 px-2 py-1 rounded font-bold text-xs">CS</div>
                    <span class="font-bold text-base">CivicSpace</span>
                </div>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white p-1 rounded-lg hover:bg-gray-700">
                    ✕
                </button>
            </div>

            <!-- Menu Navigasi Sidebar -->
            <nav class="space-y-1">
                <!-- Poin 1 & 2: Publik -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-indigo-600 text-white font-medium text-sm">
                    <span>Explore Facilities</span>
                </a>

                <!-- Poin 3, 4, 5, 6, 7: Khusus Pengguna Login -->@auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition text-sm">
                        <span>Riwayat Reservasi</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition text-sm">
                        <span>Lapor Kerusakan</span>
                    </a>
                @endauth
            </nav>
        </div>

        <!-- Info Akun di Bawah Sidebar -->
        @auth
            <div class="border-t border-gray-700 pt-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="text-xs truncate">
                    <p class="font-semibold text-gray-200 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        @endauth
    </aside>

    <!-- 2. KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        
        <!-- Header / Navbar Atas -->
        <header class="bg-gray-800 border-b border-gray-700 px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- Tombol Buka/Tutup Sidebar -->
                <button @click="sidebarOpen = !sidebarOpen" class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg border border-gray-600 text-sm flex items-center gap-2">
                    <span>☰</span>
                    <span class="hidden sm:inline">Menu</span>
                </button>
                <h1 class="text-base font-semibold text-gray-200">Sistem Reservasi Fasilitas</h1>
            </div>

            <!-- Area Kanan Header: Status Auth / Logout -->
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:underline">Log in</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-md text-sm">Register</a>
                @else
                    <!-- Menampilkan Nama & Tombol Logout sebagai pengganti tombol Dashboard -->
                    <span class="text-sm text-gray-300 font-medium hidden sm:inline">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-rose-600/20 text-rose-400 hover:bg-rose-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-semibold border border-rose-500/30 transition">
                            Keluar
                        </button>
                    </form>
                @endguest
            </div>
        </header>

        <!-- Area Isi Halaman Utama -->
        <main class="flex-1 overflow-y-auto p-6 max-w-7xl w-full mx-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>