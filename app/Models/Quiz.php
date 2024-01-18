<?php

namespace App\Models;

use App\Models\QuizCategory;
use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quiz';
    protected $fillable = [
        'quiz_category_id',
        'name',
        'image',
        'tags',
        'status',
        'expiry_date',
    ];


    public function quiz_category(){
        return $this->belongsTo(QuizCategory::class, 'quiz_category_id');
    }

    public function quiz_question(){
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }
}
