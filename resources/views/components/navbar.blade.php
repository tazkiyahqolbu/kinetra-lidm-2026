<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2 shrink-0">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">K</span>
                </div>
                <span class="font-bold text-xl text-gray-800">KINETRA</span>
            </a>

            @guest
                <!-- Menu Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/#home" class="text-gray-700 hover:text-blue-600 transition font-medium">Home</a>
                    <a href="/#about" class="text-gray-700 hover:text-blue-600 transition font-medium">Tentang</a>
                    <a href="/#features" class="text-gray-700 hover:text-blue-600 transition font-medium">Fitur</a>
                    <a href="/#how-it-works" class="text-gray-700 hover:text-blue-600 transition font-medium">Cara Kerja</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium transition">Masuk</a>
                    <a href="/register" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                        Daftar
                    </a>
                </div>
            @else
                @php
                    $menu = auth()->user()->role === 'teacher'
                        ? [
                            ['label' => 'Beranda', 'url' => '/'],
                            ['label' => 'Ringkasan', 'url' => '/teacher/dashboard'],
                            ['label' => 'Kelas Saya', 'url' => '/teacher/classes'],
                            ['label' => 'Siswa Saya', 'url' => '/teacher/students'],
                            ['label' => 'Laporan Latihan', 'url' => '/teacher/results'],
                        ]
                        : [
                            ['label' => 'Beranda', 'url' => '/'],
                            ['label' => 'Progress Saya', 'url' => '/student/dashboard'],
                            ['label' => 'Mulai Analisis', 'url' => '/student/analysis'],
                            ['label' => 'Jejak Latihan', 'url' => '/student/history'],
                            ['label' => 'Teman Sekelas', 'url' => '/student/classmates'],
                        ];
                @endphp

                <!-- Menu Links -->
                <div class="hidden lg:flex items-center space-x-6">
                    @foreach($menu as $item)
                        <a href="{{ $item['url'] }}"
                           class="font-medium transition {{ request()->is(ltrim($item['url'], '/') ?: '/') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                <!-- Account -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="/profile" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition">
                        <span class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span class="font-medium hidden xl:inline">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </a>
                    <form method="POST" action="/logout" onsubmit="return confirm('Yakin ingin logout?')">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            @endguest

            <!-- Mobile menu button -->
            <div class="md:hidden lg:hidden">
                <button class="text-gray-700" onclick="this.parentElement.nextElementSibling.classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        @guest
            <!-- Mobile Menu -->
            <div class="hidden md:hidden pb-4 space-y-2">
                <a href="/#home" class="block text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="/#about" class="block text-gray-700 hover:text-blue-600 font-medium">Tentang</a>
                <a href="/#features" class="block text-gray-700 hover:text-blue-600 font-medium">Fitur</a>
                <a href="/#how-it-works" class="block text-gray-700 hover:text-blue-600 font-medium">Cara Kerja</a>
            </div>
        @else
            <!-- Mobile Menu -->
            <div class="hidden lg:hidden pb-4 space-y-2">
                @foreach($menu as $item)
                    <a href="{{ $item['url'] }}" class="block font-medium {{ request()->is(ltrim($item['url'], '/') ?: '/') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="/profile" class="block text-gray-700 hover:text-blue-600 font-medium">Profil Saya</a>
                <form method="POST" action="/logout" class="pt-2" onsubmit="return confirm('Yakin ingin logout?')">
                    @csrf
                    <button type="submit" class="w-full text-left bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium">
                        Logout
                    </button>
                </form>
            </div>
        @endguest
    </div>
</nav>
