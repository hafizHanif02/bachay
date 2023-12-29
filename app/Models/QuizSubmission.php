<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizAnswer;
use App\Models\familyRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizSubmission extends Model
{
    use HasFactory;
    protected $table = 'quiz_submission';
    protected $fillable = [
        'user_id',  
        'child_id',  
        'quiz_id',  
        'answer_id',  
    ];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function child(){
        return $this->belongsTo(familyRelation::class, 'child_id','id');
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }


    public function answer(){
        return $this->belongsTo(QuizAnswer::class, 'answer_id');
    }
}
