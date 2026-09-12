<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>
        @yield('title', 'Book&Fix Admin')
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.petugas.sidebar')
        <div class="flex-1">
            {{-- Header --}}
            @include('components.petugas.header')
            {{-- Content halaman --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>