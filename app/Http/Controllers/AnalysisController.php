<?php

namespace App\Http\Controllers;

use App\Models\AnalysisHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnalysisController extends Controller
{
    public function index()
    {
        $histories = AnalysisHistory::with('student.user')->get();
        return response()->json($histories);
    }

    public function storeSummary(Request $request)
    {
        $validated = $request->validate([
            'repetition' => 'required|integer|min:0',
            'rom' => 'required|numeric',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|array',
            'angles' => 'nullable|array',
            'snapshot_start' => 'nullable|string',
            'snapshot_bottom' => 'nullable|string',
            'snapshot_end' => 'nullable|string',
        ]);

        $student = Auth::user()->studentProfile;

        if (! $student) {
            return response()->json([
                'message' => 'Profil siswa tidak ditemukan.',
            ], 422);
        }

        $history = AnalysisHistory::create([
            'student_id' => $student->id,
            'date' => now()->toDateString(),
            'repetition' => $validated['repetition'],
            'rom' => $validated['rom'],
            'score' => $validated['score'],
            'feedback' => json_encode($validated['feedback'] ?? []),
            'video_path' => null,
            'angles' => $validated['angles'] ?? [],
            'snapshot_start_path' => $this->storeSnapshot($validated['snapshot_start'] ?? null, $student->id),
            'snapshot_bottom_path' => $this->storeSnapshot($validated['snapshot_bottom'] ?? null, $student->id),
            'snapshot_end_path' => $this->storeSnapshot($validated['snapshot_end'] ?? null, $student->id),
        ]);

        return response()->json([
            'message' => 'Sesi analisis berhasil disimpan.',
            'id' => $history->id,
        ], 201);
    }

    private function storeSnapshot(?string $base64, int $studentId): ?string
    {
        if (empty($base64)) {
            return null;
        }

        $binary = base64_decode($base64, true);

        if ($binary === false) {
            return null;
        }

        $path = 'snapshots/' . $studentId . '_' . Str::random(12) . '.jpg';
        Storage::disk('public')->put($path, $binary);

        return $path;
    }
}
