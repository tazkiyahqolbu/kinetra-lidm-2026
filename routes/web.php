<?php

use Illuminate\Support\Facades\Route;

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
