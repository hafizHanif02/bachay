<?php

namespace App\Models;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    public function articlecategory()
    {
        return $this->belongsTo(ArticleCategory::class,'article_category_id','id');
    }
}
