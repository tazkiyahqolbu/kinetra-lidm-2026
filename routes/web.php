<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AnalysisController;

// ==========================================
// PUBLIC ROUTES (Bisa Diakses Tanpa Login)
// ==========================================
Route::get('/', function () {
    return response()->json(['message' => 'Selamat datang di API Kinetra']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ==========================================
// PROTECTED ROUTES (Harus Login Terlebih Dahulu)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- GROUP KHUSUS TEACHER (GURU) ---
    Route::middleware(['role:teacher'])->group(function () {
        // Dashboard Guru
        Route::get('/dashboard/teacher', function () {
            return response()->json(['message' => 'Welcome to Teacher Dashboard']);
        });

        // CRUD Kelas
        Route::get('/classes', [ClassController::class, 'index']);
        Route::post('/classes', [ClassController::class, 'store']);
        Route::put('/classes/{id}', [ClassController::class, 'update']);
        Route::delete('/classes/{id}', [ClassController::class, 'destroy']);

        // CRUD Student
        Route::get('/students', [StudentController::class, 'index']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::put('/students/{id}', [StudentController::class, 'update']);
        Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    });

    // --- GROUP KHUSUS STUDENT (SISWA) ---
    Route::middleware(['role:student'])->group(function () {
        // Dashboard Siswa
        Route::get('/dashboard/student', function () {
            return response()->json(['message' => 'Welcome to Student Dashboard']);
        });
    });

    // --- SHARED ROUTES (Bisa Diakses Guru & Siswa) ---
    Route::get('/history', [AnalysisController::class, 'index']);
// Landing Page
Route::get('/', function () {
    return view('landing.index');
});

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Teacher Routes
Route::get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->name('teacher.dashboard');

Route::get('/teacher/classes', function () {
    return view('teacher.classes');
})->name('teacher.classes');

Route::get('/teacher/students', function () {
    return view('teacher.students');
})->name('teacher.students');

Route::get('/teacher/results', function () {
    return view('teacher.results');
})->name('teacher.results');

Route::get('/teacher/detail/{id}', function ($id) {
    return view('teacher.detail', ['id' => $id]);
})->name('teacher.detail');

// Student Routes
Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

Route::get('/student/analysis', function () {
    return view('student.analysis');
})->name('student.analysis');

Route::get('/student/history', function () {
    return view('student.history');
})->name('student.history');

// Profile
Route::get('/profile', function () {
    return view('profile.index');
})->name('profile');
