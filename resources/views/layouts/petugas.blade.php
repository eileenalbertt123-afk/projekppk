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

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; }

        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 228px;
            height: 100vh;
            z-index: 50;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        #mainContent {
            margin-left: 228px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        #sidebar.collapsed   { width: 0; }
        #mainContent.collapsed { margin-left: 0; }
    </style>
</head>

<body class="bg-gray-50">

    @include('components.petugas.sidebar')

    <div id="mainContent">
        @include('components.petugas.header')
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar     = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggle      = document.getElementById('sidebarToggle');

        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });
    </script>

    @stack('scripts')

</body>
</html>