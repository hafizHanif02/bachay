<?php

namespace App\Models;

use App\Model\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
