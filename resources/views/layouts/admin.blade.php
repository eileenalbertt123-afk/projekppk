<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Book & Fix') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="font-sans antialiased bg-[#f5f7f7] text-[#19183b]">

    <div class="min-h-screen">


        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}

        <div id="adminBackdrop" class="fixed inset-0 z-[45] bg-black/40 hidden lg:hidden"></div>
        <aside
            id="adminSidebar"
            class="fixed inset-y-0 left-0 z-50 w-[290px] -translate-x-full
                   bg-white border-r border-[#e2ebe9]
                   transition-transform duration-300 ease-in-out">
            @include('layouts.admin-sidebar')

        </aside>


        {{-- =========================================================
            AREA UTAMA
        ========================================================== --}}

        <div
            id="adminMain"
            class="min-h-screen lg:ml-[290px]
                   transition-all duration-300 ease-in-out">


            {{-- =====================================================
                HEADER
            ====================================================== --}}

            <header
                class="sticky top-0 z-40
                       h-16 sm:h-[90px]
                       bg-white
                       border-b border-[#e2ebe9]
                       flex items-center justify-between
                       px-4 sm:px-8">


                {{-- MENU --}}

                <button
                    type="button"
                    id="menuButton"
                    class="flex items-center gap-2
                           px-3 py-2 sm:px-4 sm:py-2.5
                           rounded-xl
                           border border-[#dfe8e6]
                           bg-white
                           text-[#19183b]
                           hover:bg-[#f4f8f7]
                           transition">

                    <svg
                        class="size-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />

                    </svg>

                    <span class="text-sm font-medium">
                        Menu
                    </span>

                </button>


                {{-- KANAN HEADER --}}

                <div class="flex items-center gap-2 sm:gap-4">

                    <span class="hidden sm:inline text-sm text-[#708993]">

                        Halo,

                        <span class="font-semibold text-[#19183b]">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </span>

                    </span>


                    {{-- LOGOUT --}}

                    <form
                        method="POST"
                        action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="px-3 py-1.5 sm:px-4 sm:py-2
                                   rounded-xl
                                   border border-[#f2caca]
                                   bg-white
                                   text-[#d94b4b]
                                   text-sm font-medium
                                   hover:bg-[#d94b4b]
                                   hover:border-[#d94b4b]
                                   hover:text-white
                                   transition duration-200">

                            Keluar

                        </button>

                    </form>

                </div>

            </header>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}

            <main class="min-w-0 px-4 py-5 sm:px-8 sm:py-8">

                @yield('content')

            </main>


        </div>

    </div>


    {{-- =========================================================
        SIDEBAR TOGGLE
    ========================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('menuButton');
            const sidebar = document.getElementById('adminSidebar');
            const main = document.getElementById('adminMain');
            const backdrop = document.getElementById('adminBackdrop');
            if (!btn || !sidebar || !main || !backdrop) return;

            const isDesktop = () => window.matchMedia('(min-width: 1024px)').matches;
            let open = isDesktop();

            function apply() {
                sidebar.classList.toggle('-translate-x-full', !open);
                main.classList.toggle('lg:ml-[290px]', open);
                backdrop.classList.toggle('hidden', !(open && !isDesktop()));
            }

            btn.addEventListener('click', () => {
                open = !open;
                apply();
            });
            backdrop.addEventListener('click', () => {
                open = false;
                apply();
            });
            apply();
        });
    </script>


</body>

</html>