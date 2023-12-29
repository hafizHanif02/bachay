<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizCategory extends Model
{
    use HasFactory;
    protected $table = 'quiz_categories';
    protected $fillable = [
        'name',
        'image',
        'expiry,',
    ];


    public function quiz(){
        return $this->hasMany(Quiz::class);
    }
}
