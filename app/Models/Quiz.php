<?php

namespace App\Models;

use App\Models\QuizAnswer;
use App\Models\QuizCategory;
use App\Models\QuizSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quiz';
    protected $fillable = [
        'quiz_category_id',
        'question,',
        'answer_id',
    ];

    public function category(){
        return $this->belongsTo(QuizCategory::class, 'quiz_category_id');
    }

    public function answer(){
        return $this->hasMany(QuizAnswer::class, 'quiz_id');
    }

    public function submissions(){
        return $this->hasMany(QuizSubmission::class, 'quiz_id');
    }
}
