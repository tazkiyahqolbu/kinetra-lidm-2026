
@extends('layouts.app')

@section('title', 'Register - KINETRA')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-emerald-50 pt-20 pb-20">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">K</span>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar di KINETRA</h1>
                <p class="text-gray-600">Mulai perjalanan analisis gerak Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="/register" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nama Anda"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@example.com"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition"
                    >
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition"
                    >
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilih Peran
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition">
                            <input type="radio" name="role" value="guru" class="h-4 w-4 text-blue-600" onchange="toggleStudentFields()" {{ old('role') === 'guru' ? 'checked' : '' }} required>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">Guru PJOK</p>
                                <p class="text-sm text-gray-600">Kelola kelas dan pantau progress siswa</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-600 hover:bg-blue-50 transition">
                            <input type="radio" name="role" value="siswa" class="h-4 w-4 text-blue-600" onchange="toggleStudentFields()" {{ old('role') === 'siswa' ? 'checked' : '' }} required>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">Siswa</p>
                                <p class="text-sm text-gray-600">Latih teknik olahraga dan pantau progress</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Student-only fields -->
                <div id="student-fields" class="space-y-4 {{ old('role') === 'siswa' ? '' : 'hidden' }}">
                    <div>
                        <label for="class_code" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode Kelas
                        </label>
                        <input
                            type="text"
                            id="class_code"
                            name="class_code"
                            value="{{ old('class_code') }}"
                            placeholder="Minta kode ini ke guru PJOK Anda"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition uppercase"
                        >
                    </div>
                    <div>
                        <label for="nis" class="block text-sm font-semibold text-gray-700 mb-2">
                            NIS
                        </label>
                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            value="{{ old('nis') }}"
                            placeholder="Nomor Induk Siswa"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition"
                        >
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input
                        type="checkbox"
                        id="terms"
                        class="h-4 w-4 text-blue-600 rounded mt-1"
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Saya setuju dengan
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Syarat dan Ketentuan</a>
                    </label>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg hover:shadow-xl">
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center mt-6 text-gray-600">
                Sudah punya akun?
                <a href="/login" class="text-blue-600 font-semibold hover:text-blue-700 transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function toggleStudentFields() {
        const isStudent = document.querySelector('input[name="role"]:checked')?.value === 'siswa';
        document.getElementById('student-fields').classList.toggle('hidden', !isStudent);
    }
</script>
@endsection
