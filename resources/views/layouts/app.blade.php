<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">

<head>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
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
                    boxShadow: {
                        panel: '0 8px 30px -8px rgba(15, 23, 42, 0.15)',
                        card: '0 2px 10px rgba(15, 23, 42, 0.07)',
                        'card-hover': '0 8px 20px rgba(15, 23, 42, 0.12)',
                    },
                    keyframes: {
                        'fade-up': {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(24px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                    },
                    animation: {
                        'fade-up': 'fade-up 0.5s ease-out both',
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
    <!-- LAPISAN GELAP (hanya HP) -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        x-transition.opacity

        class="fixed inset-0 z-40 bg-black/40 md:hidden"></div>
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

        <!-- PENGELOMPOKAN ISI ATAS (Logo & Navigasi) -->
        <div class="flex-1 flex flex-col">
            <!-- Header Logo -->
            <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-6">
                <div class="flex items-center gap-2.5">
                    <div class="flex items-center gap-2.5">
                        <div class="bg-brand-primary rounded-xl size-10 flex items-center justify-center shrink-0">
                            <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 14.25l2.25 2.25 5.25-5.25" />
                            </svg>
                        </div>
                        <p class="font-bold text-lg text-brand-primary leading-5">
                            Book<span class="text-brand-secondary">&amp;</span>Fix
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigasi Menu -->
            <nav class="space-y-1.5" @click="if ($event.target.closest('a') && window.innerWidth < 768) sidebarOpen = false">
                @guest
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
            {{ request()->routeIs('home') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                @endguest

                @auth
                @if (Auth::user()->role === 'pengguna')
                {{-- MENU PENGGUNA --}}
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('home') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('riwayat.reservasi') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('riwayat.reservasi') || request()->routeIs('reservations.detail') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7c0-1.105-.895-2-2-2H5C3.895 5 3 5.895 3 7v12c0 1.105.895 2 2 2h14a2 2 0 002-2V7" />
                    </svg>
                    <span>Riwayat Reservasi</span>
                </a>

                <a href="{{ route('riwayat.laporan') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('riwayat.laporan') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                    <span>Riwayat Laporan</span>
                </a>

                <a href="{{ route('reports.create') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('reports.create') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Lapor Kerusakan</span>
                </a>

                @elseif (Auth::user()->role === 'petugas')
                {{-- MENU PETUGAS --}}
                <a href="{{ route('petugas.reservasi.dashboard') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('petugas.reservasi.*') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 13h2l2-3 4 6 3-4h7" />
                    </svg>
                    <span>Dashboard Petugas</span>
                </a>

                @elseif (Auth::user()->role === 'admin')
                {{-- MENU ADMIN --}}
                <a href="{{ route('admin') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('admin') ? 'bg-brand-primary text-white shadow-xs' : 'text-brand-secondary hover:bg-gray-100 hover:text-brand-primary' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z" />
                    </svg>
                    <span>Dashboard Admin</span>
                </a>
                @endif
                @endauth
            </nav>


        </div>

        <!-- Akun di Bawah Sidebar (Posisi dikunci mt-auto) -->
        @auth
        <div class="border-t border-gray-100 pt-4 mt-auto flex items-center gap-3">
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
        <header class="bg-white border-b border-gray-200 px-3 py-3 sm:px-6 sm:py-3.5 flex items-center justify-between shadow-xs gap-2">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <button @click="sidebarOpen = !sidebarOpen" class="bg-brand-neutral hover:bg-gray-200 text-brand-primary px-3 py-1.5 rounded-lg border border-gray-200 text-sm flex items-center gap-2 transition font-medium">
                    <span>☰</span>
                    <span class="hidden sm:inline">Menu</span> xzvddsvsbdvbsvbss
                </button>
                <h1 class="text-sm sm:text-base font-bold text-brand-primary tracking-tight truncate">
            </div>

            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                @guest
                <a href="{{ route('login') }}" class="bg-brand-primary hover:opacity-95 text-white px-3.5 py-2 sm:px-5 rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm whitespace-nowrap">
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
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>