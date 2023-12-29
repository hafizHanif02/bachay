<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAnswer extends Model
{
    use HasFactory;
    protected $table = 'quiz_answer';
    protected $fillable = [
          'quiz_id',
          'answer',
    ];

    public function quiz(){
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
