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
        <div class="flex items-center gap-2.5 mb-6">
            <div class="bg-brand-primary text-white px-2.5 py-1 rounded-md font-extrabold text-xs tracking-wider">BF</div>
            <span class="font-bold text-xl text-brand-primary tracking-tight">Book & Fix</span>
        </div>

        <div class="w-full sm:max-w-md px-6 py-6 bg-white border border-gray-200 shadow-sm rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>