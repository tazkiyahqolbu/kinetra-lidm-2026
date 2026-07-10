<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalysisHistory extends Model
{
    protected $fillable = [
        'student_id', 'date', 'repetition', 'rom', 'score',
        'feedback', 'video_path', 'angles',
        'snapshot_start_path', 'snapshot_bottom_path', 'snapshot_end_path',
    ];

    protected $casts = [
        'angles' => 'array',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
