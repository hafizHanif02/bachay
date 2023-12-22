<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleCategory extends Model
{
    use HasFactory;
    protected $table = 'article_category';
    protected $fillable = [
        'name',
        'tag_line',
        'image',
        'status',
    ];


    public function articles()
    {
        return $this->hasMany(Article::class,'article_category_id','id');
    }
}
