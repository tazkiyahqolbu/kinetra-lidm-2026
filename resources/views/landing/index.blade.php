@extends('layouts.app')

@section('title', 'KINETRA - Platform Analisis Gerak PJOK Berbasis AI')

@section('content')
<!-- Hero Section -->
<section id="home" class="pt-20 pb-32 bg-gradient-to-br from-blue-50 via-white to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Text -->
            <div class="space-y-6">
                <div class="inline-block">
                    <span class="bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold">
                        Teknologi AI Terdepan
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                    KINETRA
                </h1>
                <p class="text-xl text-gray-600">
                    Platform Analisis Gerak PJOK Berbasis AI yang membantu guru dan siswa memahami teknik olahraga dengan lebih baik.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition text-center shadow-lg hover:shadow-xl">
                        Mulai Sekarang
                    </a>
                    <a href="#how-it-works" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg font-semibold transition text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Illustration -->
            <div class="flex items-center justify-center">
                <div class="relative w-full h-96">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-emerald-400 rounded-3xl opacity-20"></div>
                    <div class="absolute inset-8 bg-white rounded-3xl shadow-2xl flex items-center justify-center">
                        <div class="text-center space-y-4">
                            <div class="w-20 h-20 bg-blue-100 rounded-full mx-auto flex items-center justify-center">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m0 0l-2-1m2 1v2.5M14 4l-2 1m0 0l-2-1m2 1v2.5"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-semibold">Analisis Gerak Real-Time</p>
                            <p class="text-sm text-gray-500">Teknologi AI mendeteksi setiap gerakan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa itu KINETRA?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                KINETRA adalah solusi inovatif yang menggabungkan teknologi AI dengan pendidikan olahraga untuk memberikan analisis gerak yang akurat dan real-time.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Tujuan -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Tujuan</h3>
                <p class="text-gray-700">
                    Meningkatkan kualitas pembelajaran PJOK dengan memberikan feedback real-time dan analisis mendalam tentang teknik gerak siswa.
                </p>
            </div>

            <!-- Manfaat -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-8 rounded-xl">
                <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Manfaat</h3>
                <p class="text-gray-700">
                    Guru dapat mengidentifikasi kesalahan teknik dengan cepat, siswa mendapat feedback personal, dan pembelajaran menjadi lebih efektif.
                </p>
            </div>

            <!-- Inovasi -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20m0 0l-.75 3M9 20H5m15-5h4m0 0l.75 3M19 15h5m-15.386-2.804a1.5 1.5 0 00-2.228-2.228m7.228 8.456a1.5 1.5 0 00-2.228-2.228m7.228 8.456a1.5 1.5 0 00-2.228-2.228M5 10.5a1.5 1.5 0 1103 0 1.5 1.5 0 01-3 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inovasi</h3>
                <p class="text-gray-700">
                    Menggunakan teknologi AI terkini untuk mendeteksi pose tubuh, menganalisis ROM (Range of Motion), dan memberikan saran perbaikan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Fitur Section -->
<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Semua yang Anda butuhkan untuk analisis gerak yang komprehensif
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pose Detection -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Pose Detection</h3>
                <p class="text-gray-600">
                    AI mendeteksi 17 keypoints tubuh untuk analisis gerak yang presisi.
                </p>
            </div>

            <!-- Real-Time Analysis -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Analisis Real-Time</h3>
                <p class="text-gray-600">
                    Dapatkan feedback instan saat sedang melakukan gerakan olahraga.
                </p>
            </div>

            <!-- Teacher Dashboard -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Dashboard Guru</h3>
                <p class="text-gray-600">
                    Pantau progress seluruh kelas dan lihat analisis detail per siswa.
                </p>
            </div>

            <!-- Progress Monitoring -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Progress Monitoring</h3>
                <p class="text-gray-600">
                    Lacak perkembangan siswa dari waktu ke waktu dengan grafik interaktif.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Cara Kerja Section -->
<section id="how-it-works" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Proses sederhana untuk mendapatkan analisis gerak yang mendalam
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="space-y-8">
                <!-- Step 1 -->
                <div class="flex gap-8 items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white font-bold text-xl">
                            1
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Login</h3>
                        <p class="text-gray-600">Masuk dengan akun Anda sebagai guru atau siswa</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class="flex justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>

                <!-- Step 2 -->
                <div class="flex gap-8 items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white font-bold text-xl">
                            2
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Mulai Analisis</h3>
                        <p class="text-gray-600">Aktifkan kamera dan mulai rekam gerakan olahraga Anda</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class="flex justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>

                <!-- Step 3 -->
                <div class="flex gap-8 items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white font-bold text-xl">
                            3
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">AI Mendeteksi</h3>
                        <p class="text-gray-600">Sistem AI menganalisis gerakan dan memberikan feedback real-time</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class="flex justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>

                <!-- Step 4 -->
                <div class="flex gap-8 items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white font-bold text-xl">
                            4
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Lihat Hasil</h3>
                        <p class="text-gray-600">Dapatkan laporan lengkap dengan analisis detail dan saran perbaikan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold mb-6">Siap untuk Meningkatkan Pembelajaran Olahraga?</h2>
        <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan guru dan siswa yang telah merasakan manfaat KINETRA</p>
        <a href="/register" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
            Daftar Gratis Sekarang
        </a>
    </div>
</section>

@endsection
