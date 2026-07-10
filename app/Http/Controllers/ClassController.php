<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with('teacher')->where('teacher_id', Auth::id())->get();
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
        ]);

        ClassRoom::create([
            'teacher_id' => Auth::id(), // Mengambil ID Guru yang sedang login
            'class_name' => $validated['class_name'],
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
        ]);

        $class = ClassRoom::where('teacher_id', Auth::id())->findOrFail($id);
        $class->update(['class_name' => $validated['class_name']]);

        return back()->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $class = ClassRoom::where('teacher_id', Auth::id())->findOrFail($id);
        $class->delete();

        return back()->with('success', 'Kelas berhasil dihapus!');
    }
}
