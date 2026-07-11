<?php

namespace App\Http\Controllers;

use App\Models\AnalysisHistory;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function dashboard()
    {
        $totalKelas = ClassRoom::ownedBy(Auth::id())->count();
        $totalSiswa = Student::inClassesOwnedBy(Auth::id())->count();
        $analisisHariIni = AnalysisHistory::forTeacher(Auth::id())
            ->whereDate('date', today())
            ->count();
        $totalAnalisis = AnalysisHistory::forTeacher(Auth::id())->count();
        $aktivitasTerbaru = AnalysisHistory::with('student.user')
            ->forTeacher(Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'totalKelas', 'totalSiswa', 'analisisHariIni', 'totalAnalisis', 'aktivitasTerbaru'
        ));
    }

    public function classes()
    {
        $classes = ClassRoom::ownedBy(Auth::id())
            ->withCount('students')
            ->latest()
            ->get();

        return view('teacher.classes', compact('classes'));
    }

    public function students(Request $request)
    {
        $classes = ClassRoom::ownedBy(Auth::id())->get();

        $students = Student::with(['user', 'classRoom'])
            ->inClassesOwnedBy(Auth::id())
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
    }

    public function results()
    {
        $results = AnalysisHistory::with('student.user')
            ->forTeacher(Auth::id())
            ->latest()
            ->paginate(10);

        return view('teacher.results', compact('results'));
    }

    public function detail($id)
    {
        $history = AnalysisHistory::with('student.user', 'student.classRoom')
            ->forTeacher(Auth::id())
            ->findOrFail($id);

        $feedback = json_decode($history->feedback ?? '[]', true) ?: [];

        return view('analysis.detail', [
            'history' => $history,
            'feedback' => $feedback,
            'pageTitle' => 'Detail Laporan Latihan',
            'subtitle' => 'Analisis detail gerakan siswa',
            'backUrl' => '/teacher/results',
            'chartId' => 'chart-teacher-' . $history->id,
            'showStudentInfo' => true,
        ]);
    }
}
