<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KINETRA - Platform Analisis Gerak PJOK')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <!-- Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')
</body>
</html>
