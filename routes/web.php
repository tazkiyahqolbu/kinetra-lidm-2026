<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AnalysisController;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\AnalysisHistory;

// ==========================================
// PUBLIC ROUTES (Bisa Diakses Tanpa Login)
// ==========================================
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ==========================================
// PROTECTED ROUTES (Harus Login Terlebih Dahulu)
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');

    // --- GROUP KHUSUS TEACHER (GURU) ---
    Route::middleware(['role:teacher'])->group(function () {

        Route::get('/teacher/dashboard', function () {
            $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
            $studentIds = Student::whereIn('class_id', $classIds)->pluck('id');

            $totalKelas = $classIds->count();
            $totalSiswa = $studentIds->count();
            $analisisHariIni = AnalysisHistory::whereIn('student_id', $studentIds)
                ->whereDate('date', today())
                ->count();
            $totalAnalisis = AnalysisHistory::whereIn('student_id', $studentIds)->count();
            $aktivitasTerbaru = AnalysisHistory::with('student.user')
                ->whereIn('student_id', $studentIds)
                ->latest()
                ->take(5)
                ->get();

            return view('teacher.dashboard', compact(
                'totalKelas', 'totalSiswa', 'analisisHariIni', 'totalAnalisis', 'aktivitasTerbaru'
            ));
        })->name('teacher.dashboard');

        Route::get('/teacher/classes', function () {
            $classes = ClassRoom::where('teacher_id', Auth::id())
                ->withCount('students')
                ->latest()
                ->get();

            return view('teacher.classes', compact('classes'));
        })->name('teacher.classes');

        Route::get('/teacher/students', function (\Illuminate\Http\Request $request) {
            $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
            $classes = ClassRoom::where('teacher_id', Auth::id())->get();

            $students = Student::with(['user', 'classRoom'])
                ->whereIn('class_id', $classIds)
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->whereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->input('search') . '%');
                    });
                })
                ->when($request->filled('class_id'), function ($query) use ($request) {
                    $query->where('class_id', $request->input('class_id'));
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('teacher.students', compact('students', 'classes'));
        })->name('teacher.students');

        Route::get('/teacher/results', function () {
            $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
            $studentIds = Student::whereIn('class_id', $classIds)->pluck('id');
            $results = AnalysisHistory::with('student.user')
                ->whereIn('student_id', $studentIds)
                ->latest()
                ->paginate(10);

            return view('teacher.results', compact('results'));
        })->name('teacher.results');

        Route::get('/teacher/detail/{id}', function ($id) {
            $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
            $studentIds = Student::whereIn('class_id', $classIds)->pluck('id');

            $history = AnalysisHistory::with('student.user', 'student.classRoom')
                ->whereIn('student_id', $studentIds)
                ->findOrFail($id);

            $feedback = json_decode($history->feedback ?? '[]', true) ?: [];

            return view('teacher.detail', compact('history', 'feedback'));
        })->name('teacher.detail');

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

        Route::get('/student/dashboard', function () {
            $student = Auth::user()->studentProfile;
            $histories = $student ? $student->analysisHistories()->latest()->get() : collect();

            $latihanTerakhir = $histories->first();
            $sebelumnya = $histories->skip(1)->first();
            $nilaiTerbaik = $histories->max('score');
            $rataRata = $histories->isNotEmpty() ? round($histories->avg('score')) : null;
            $totalLatihan = $histories->count();
            $sesiMingguIni = $histories->filter(
                fn ($item) => \Carbon\Carbon::parse($item->date)->isSameWeek(now())
            )->count();
            $riwayatTerbaru = $histories->take(5);

            return view('student.dashboard', compact(
                'latihanTerakhir', 'sebelumnya', 'nilaiTerbaik', 'rataRata',
                'totalLatihan', 'sesiMingguIni', 'riwayatTerbaru'
            ));
        })->name('student.dashboard');

        Route::get('/student/analysis', function () {
            return view('student.analysis');
        })->name('student.analysis');

        Route::post('/student/analysis/summary', [AnalysisController::class, 'storeSummary'])
            ->name('student.analysis.summary');

        Route::get('/student/history', function () {
            $student = Auth::user()->studentProfile;
            $histories = $student
                ? $student->analysisHistories()->latest()->paginate(10)
                : AnalysisHistory::whereRaw('1 = 0')->paginate(10);

            return view('student.history', compact('histories'));
        })->name('student.history');

        Route::get('/student/history/{id}', function ($id) {
            $student = Auth::user()->studentProfile;

            $history = $student
                ? $student->analysisHistories()->findOrFail($id)
                : abort(404);

            $feedback = json_decode($history->feedback ?? '[]', true) ?: [];

            return view('student.detail', compact('history', 'feedback'));
        })->name('student.history.detail');
    });

    // --- SHARED ROUTES (Bisa Diakses Guru & Siswa) ---
    Route::get('/history', [AnalysisController::class, 'index']);
});
