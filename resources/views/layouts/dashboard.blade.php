<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - KINETRA')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <!-- Navbar -->
    @include('components.navbar')

    <!-- Content -->
    <main class="min-h-screen p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('components.footer')
</body>
</html>
