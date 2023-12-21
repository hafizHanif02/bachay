<?php

namespace App\Models;

use App\Models\QnaQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QnaAnswer extends Model
{
    use HasFactory;
    protected $table = 'qna_answer';
    protected $fillable = [
        'question_id',
        'answer',
        'user_id'
    ];


    public function question()
    {
        return $this->belongsTo(QnaQuestion::class, 'question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name','f_name', 'l_name', 'image']);
    }
}
