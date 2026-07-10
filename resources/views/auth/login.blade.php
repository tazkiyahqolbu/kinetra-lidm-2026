@extends('layouts.app')

@section('title', 'Login - KINETRA')

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
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke KINETRA</h1>
                <p class="text-gray-600">Lanjutkan analisis gerak Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="/login" class="space-y-5">
                @csrf

                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg p-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
                        {{ $errors->first() }}
                    </div>
                @endif

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

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="h-4 w-4 text-blue-600 rounded"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Ingat saya
                    </label>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg hover:shadow-xl">
                    Masuk
                </button>
            </form>

            <!-- Register Link -->
            <p class="text-center mt-6 text-gray-600">
                Belum punya akun? 
                <a href="/register" class="text-blue-600 font-semibold hover:text-blue-700 transition">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
