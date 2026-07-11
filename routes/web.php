<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\StudentDashboardController;

// Rute publik, bisa diakses tanpa login
Route::get('/', function () {
    return view('landing.index');
});

Route::middleware(['guest'])->group(function () {

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/register', [AuthController::class, 'register']);

// Rute yang wajib login
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');

    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');

    // --- GROUP KHUSUS TEACHER (GURU) ---
    Route::middleware(['role:teacher'])->group(function () {

        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])
            ->name('teacher.dashboard');

        Route::get('/teacher/classes', [TeacherDashboardController::class, 'classes'])
            ->name('teacher.classes');

        Route::get('/teacher/students', [TeacherDashboardController::class, 'students'])
            ->name('teacher.students');

        Route::get('/teacher/results', [TeacherDashboardController::class, 'results'])
            ->name('teacher.results');

        Route::get('/teacher/detail/{id}', [TeacherDashboardController::class, 'detail'])
            ->name('teacher.detail');

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

        Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])
            ->name('student.dashboard');

        Route::get('/student/analysis', function () {
            return view('student.analysis');
        })->name('student.analysis');

        Route::post('/student/analysis/summary', [AnalysisController::class, 'storeSummary'])
            ->name('student.analysis.summary');

        Route::get('/student/history', [StudentDashboardController::class, 'history'])
            ->name('student.history');

        Route::get('/student/history/{id}', [StudentDashboardController::class, 'historyDetail'])
            ->name('student.history.detail');

        Route::get('/student/classmates', [StudentDashboardController::class, 'classmates'])
            ->name('student.classmates');
    });
});
