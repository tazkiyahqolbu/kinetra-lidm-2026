<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'class_id', 'nis'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classRoom() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function analysisHistories() {
        return $this->hasMany(AnalysisHistory::class, 'student_id');
    }
}
