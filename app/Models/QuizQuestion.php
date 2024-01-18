<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizCategory;
use App\Models\QuizSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $table = 'quiz_questions';
    protected $fillable = [
        'quiz_id',
        'question,',
        'answer_id',
    ];

    public function answer(){
        return $this->hasMany(QuizAnswer::class, 'quiz_id');
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function submissions(){
        return $this->hasMany(QuizSubmission::class, 'quiz_id');
    }
}
