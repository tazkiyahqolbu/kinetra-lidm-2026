<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">K</span>
                </div>
                <span class="font-bold text-xl text-gray-800">KINETRA</span>
            </div>

            <!-- Menu Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-gray-700 hover:text-blue-600 transition font-medium">Home</a>
                <a href="#about" class="text-gray-700 hover:text-blue-600 transition font-medium">Tentang</a>
                <a href="#features" class="text-gray-700 hover:text-blue-600 transition font-medium">Fitur</a>
                <a href="#how-it-works" class="text-gray-700 hover:text-blue-600 transition font-medium">Cara Kerja</a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center space-x-4">
                <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium transition">Masuk</a>
                <a href="/register" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                    Daftar
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-gray-700" onclick="this.parentElement.nextElementSibling.classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden pb-4 space-y-2">
            <a href="#home" class="block text-gray-700 hover:text-blue-600 font-medium">Home</a>
            <a href="#about" class="block text-gray-700 hover:text-blue-600 font-medium">Tentang</a>
            <a href="#features" class="block text-gray-700 hover:text-blue-600 font-medium">Fitur</a>
            <a href="#how-it-works" class="block text-gray-700 hover:text-blue-600 font-medium">Cara Kerja</a>
        </div>
    </div>
</nav>
