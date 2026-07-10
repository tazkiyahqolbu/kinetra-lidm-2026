<?php

namespace App\Http\Controllers;

use App\Models\AnalysisHistory;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index()
    {
        $histories = AnalysisHistory::with('student.user')->get();
        return response()->json($histories);
    }
}
