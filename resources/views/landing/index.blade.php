@extends('layouts.app')

@section('title', 'KINETRA - Platform Analisis Gerak PJOK Berbasis AI')

@section('content')
<!-- Hero Section -->
<section id="home" class="pt-20 pb-24 bg-white border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-blue-600 font-semibold text-sm uppercase tracking-wide mb-4">Analisis Gerak PJOK</p>
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
            KINETRA
        </h1>
        <p class="text-xl text-gray-600 mt-6 max-w-2xl mx-auto">
            Platform analisis gerak squat berbasis AI yang membantu guru dan siswa memahami teknik olahraga dengan lebih baik.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
            @guest
                <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition text-center">
                    Mulai Sekarang
                </a>
            @elseif(auth()->user()->role === 'teacher')
                <a href="/teacher/dashboard" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition text-center">
                    Lihat Ringkasan Saya
                </a>
            @else
                <a href="/student/analysis" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition text-center">
                    Mulai Analisis
                </a>
            @endguest
            <a href="#how-it-works" class="border-2 border-gray-300 text-gray-700 hover:border-gray-400 px-8 py-4 rounded-lg font-semibold transition text-center">
                Pelajari Lebih Lanjut
            </a>
        </div>

        <!-- Key facts -->
        <div class="grid grid-cols-3 gap-6 mt-16 pt-10 border-t border-gray-200 text-left">
            <div>
                <p class="text-3xl font-bold text-gray-900">17</p>
                <p class="text-sm text-gray-500 mt-1">Titik tubuh terdeteksi per frame</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-900">3</p>
                <p class="text-sm text-gray-500 mt-1">Foto representatif per sesi</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-900">Real-time</p>
                <p class="text-sm text-gray-500 mt-1">Feedback langsung saat bergerak</p>
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
            <div class="border-t-2 border-blue-600 pt-6">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Tujuan</h3>
                <p class="text-gray-700">
                    Meningkatkan kualitas pembelajaran PJOK dengan memberikan feedback real-time dan analisis mendalam tentang teknik gerak siswa.
                </p>
            </div>

            <!-- Manfaat -->
            <div class="border-t-2 border-emerald-500 pt-6">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Manfaat</h3>
                <p class="text-gray-700">
                    Guru dapat mengidentifikasi kesalahan teknik dengan cepat, siswa mendapat feedback personal, dan pembelajaran menjadi lebih efektif.
                </p>
            </div>

            <!-- Inovasi -->
            <div class="border-t-2 border-purple-500 pt-6">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inovasi</h3>
                <p class="text-gray-700">
                    Menggunakan teknologi AI untuk mendeteksi pose tubuh, menganalisis ROM (Range of Motion), dan memberikan saran perbaikan.
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
            <div class="bg-white p-8 rounded-xl border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Pose Detection</h3>
                <p class="text-gray-600">
                    AI mendeteksi 17 titik tubuh untuk analisis gerak yang presisi.
                </p>
            </div>

            <!-- Real-Time Analysis -->
            <div class="bg-white p-8 rounded-xl border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Analisis Real-Time</h3>
                <p class="text-gray-600">
                    Dapatkan feedback instan saat sedang melakukan gerakan olahraga.
                </p>
            </div>

            <!-- Teacher Dashboard -->
            <div class="bg-white p-8 rounded-xl border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Ringkasan Guru</h3>
                <p class="text-gray-600">
                    Pantau progress seluruh kelas dan lihat analisis detail per siswa.
                </p>
            </div>

            <!-- Progress Monitoring -->
            <div class="bg-white p-8 rounded-xl border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Riwayat Latihan</h3>
                <p class="text-gray-600">
                    Lacak skor, ROM, dan grafik sudut lutut setiap sesi latihan siswa.
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
        @guest
            <h2 class="text-4xl font-bold mb-6">Siap untuk Meningkatkan Pembelajaran Olahraga?</h2>
            <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan guru dan siswa yang telah merasakan manfaat KINETRA</p>
            <a href="/register" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
                Daftar Gratis Sekarang
            </a>
        @elseif(auth()->user()->role === 'teacher')
            <h2 class="text-4xl font-bold mb-6">Pantau Progress Siswa Anda</h2>
            <p class="text-xl mb-8 text-blue-100">Lihat ringkasan kelas dan hasil latihan siswa Anda hari ini</p>
            <a href="/teacher/dashboard" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
                Lihat Ringkasan
            </a>
        @else
            <h2 class="text-4xl font-bold mb-6">Siap Latihan Hari Ini?</h2>
            <p class="text-xl mb-8 text-blue-100">Lanjutkan progress squat kamu dan raih skor terbaikmu</p>
            <a href="/student/analysis" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
                Mulai Analisis Sekarang
            </a>
        @endguest
    </div>
</section>

@endsection
