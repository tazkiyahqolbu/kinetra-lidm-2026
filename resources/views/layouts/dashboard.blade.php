<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - KINETRA')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <!-- Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-screen bg-white shadow-lg z-40 pt-20 overflow-y-auto">
        @include('components.sidebar', ['role' => $role ?? 'Guru'])
    </div>

    <!-- Main Content -->
    <div class="md:ml-64">
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
    </div>

    <style>
        @media (max-width: 768px) {
            .fixed.left-0 {
                left: -256px;
                transition: left 0.3s ease;
            }
            
            .fixed.left-0.show {
                left: 0;
            }
        }
    </style>
</body>
</html>
