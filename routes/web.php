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
});
