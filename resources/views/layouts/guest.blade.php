<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Book N Fix') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 2px 10px rgba(15, 23, 42, 0.07)',
                        panel: '0 8px 30px -8px rgba(15, 23, 42, 0.15)',
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
</head>
<body class="font-sans text-brand-primary antialiased bg-brand-neutral">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10">

        <!-- Logo (di tengah) -->
        <div class="w-full flex items-center justify-center gap-3 mb-8">
            <div class="bg-brand-primary rounded-xl size-12 flex items-center justify-center shrink-0 shadow-card">
                <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 14.25l2.25 2.25 5.25-5.25" />
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-brand-primary tracking-tight">
                Book<span class="text-brand-secondary">&amp;</span>Fix
            </h1>
        </div>

        <!-- Kartu -->
        <div class="w-full sm:max-w-lg px-6 sm:px-10 py-8 sm:py-10 bg-white border border-gray-200 shadow-panel rounded-3xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>