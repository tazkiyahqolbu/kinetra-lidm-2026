<?php

namespace App\Http\Controllers;

use App\Models\AnalysisHistory;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
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
    }

    public function history()
    {
        $student = Auth::user()->studentProfile;
        $histories = $student
            ? $student->analysisHistories()->latest()->paginate(10)
            : AnalysisHistory::whereRaw('1 = 0')->paginate(10);

        return view('student.history', compact('histories'));
    }

    public function historyDetail($id)
    {
        $student = Auth::user()->studentProfile;

        $history = $student
            ? $student->analysisHistories()->findOrFail($id)
            : abort(404);

        $feedback = json_decode($history->feedback ?? '[]', true) ?: [];

        return view('analysis.detail', [
            'history' => $history,
            'feedback' => $feedback,
            'pageTitle' => 'Detail Latihan',
            'subtitle' => \Carbon\Carbon::parse($history->date)->format('d M Y') . ' - Squat',
            'backUrl' => '/student/history',
            'chartId' => 'chart-student-' . $history->id,
            'showStudentInfo' => false,
        ]);
    }

    public function classmates()
    {
        $student = Auth::user()->studentProfile;

        $classmates = $student
            ? Student::with('user')
                ->where('class_id', $student->class_id)
                ->where('id', '!=', $student->id)
                ->get()
            : collect();

        return view('student.classmates', compact('student', 'classmates'));
    }
}
