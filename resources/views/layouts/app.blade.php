<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            primary: '#19183B',
                            secondary: '#708993',
                            tertiary: '#A1C2BD',
                            neutral: '#F4F8F7',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-brand-neutral font-sans text-brand-primary h-screen flex relative overflow-hidden antialiased">
    <!-- SIDEBAR KIRI -->
    <aside 
        x-show="sidebarOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between p-5 fixed md:static inset-y-0 left-0 z-50 h-full shadow-sm overflow-y-auto">
        
        <div>
            <!-- Header Logo -->
            <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-6">
                <div class="flex items-center gap-2.5">
                    <div class="bg-brand-primary text-white px-2.5 py-1 rounded-md font-extrabold text-xs tracking-wider">BF</div>
                <span class="font-bold text-lg text-brand-primary tracking-tight">Book & Fix</span>
                </div>
                <button @click="sidebarOpen = false" class="text-brand-secondary hover:text-brand-primary p-1 rounded-lg hover:bg-gray-100 md:hidden">
                    ✕
                </button>
            </div>

            <!-- Navigasi Menu -->
            <nav class="space-y-1.5">
                @guest
                    <!-- JIKA BELUM LOGIN: Bersih & Minimalis (Sesuai SRS & Aroomi) -->
                    <div class="px-3 py-2 text-[11px] font-bold text-brand-secondary uppercase tracking-wider mb-1">Menu Utama</div>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-brand-primary text-white font-semibold text-sm shadow-sm">
                        <span>🏠 Beranda / Fasilitas</span>
                    </a>
                @endguest

                @auth
                    <!-- JIKA SUDAH LOGIN: Menu Sesuai Role -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-brand-secondary hover:bg-gray-100 hover:text-brand-primary font-medium transition text-sm">
                        <span>🏠 Beranda / Fasilitas</span>
                    </a>

                    <div class="pt-4 pb-2 px-3 text-[11px] font-bold text-brand-secondary uppercase tracking-wider">Menu Pengguna</div>
                    
                    @if(Auth::user()->isMahasiswa() || Auth::user()->isDosen())
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-brand-secondary hover:bg-gray-100 hover:text-brand-primary font-medium transition text-sm">
                            <span>📅 Riwayat & Status</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-brand-secondary hover:bg-gray-100 hover:text-brand-primary font-medium transition text-sm">
                            <span>⚠️ Lapor Kerusakan</span>
                        </a>
                    @endif

                    @if(Auth::user()->isPetugas())
                        <div class="pt-4 pb-2 px-3 text-[11px] font-bold text-brand-secondary uppercase tracking-wider">Menu Petugas</div>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-brand-secondary hover:bg-gray-100 hover:text-brand-primary font-medium transition text-sm">
                            <span>📋 Validasi Reservasi</span>
                        </a>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <div class="pt-4 pb-2 px-3 text-[11px] font-bold text-brand-secondary uppercase tracking-wider">Menu Admin</div>
                        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-brand-secondary hover:bg-gray-100 hover:text-brand-primary font-medium transition text-sm">
                            <span>⚙️ Kelola Fasilitas</span>
                        </a>
                    @endif
                @endauth
            </nav>
        </div>

        <!-- Akun di Bawah Sidebar -->
        @auth
            <div class="border-t border-gray-100 pt-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold text-sm shrink-0">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="text-xs truncate">
                    <p class="font-bold text-brand-primary truncate">{{ Auth::user()->name }}</p>
                    <p class="text-brand-secondary truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        @endauth
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden bg-brand-neutral">
        
        <!-- Header Atas -->
        <header class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="bg-brand-neutral hover:bg-gray-200 text-brand-primary px-3 py-1.5 rounded-lg border border-gray-200 text-sm flex items-center gap-2 transition font-medium">
                    <span>☰</span>
                    <span class="hidden sm:inline">Menu</span>
                </button>
                <h1 class="text-base font-bold text-brand-primary tracking-tight">Sistem Reservasi Fasilitas Kampus</h1>
            </div>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="bg-brand-primary hover:opacity-95 text-white px-5 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
                        Sign In
                    </a>
                @else
                    <span class="text-sm text-brand-secondary font-medium hidden sm:inline">Halo, <strong class="text-brand-primary">{{ Auth::user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-3.5 py-1.5 rounded-xl text-xs font-bold border border-rose-200 transition">
                            Keluar
                        </button>
                    </form>
                @endguest
            </div>
        </header>

        <!-- Tempat Konten Berubah-ubah -->
        <main class="flex-1 overflow-y-auto p-6 max-w-7xl w-full mx-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>