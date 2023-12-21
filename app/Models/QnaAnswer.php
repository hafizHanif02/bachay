<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnaAnswer extends Model
{
    use HasFactory;
    protected $table = 'qna_answer';
    protected $fillable = [
        'question_id',
        'answer',
        'user_id'
    ];
}
