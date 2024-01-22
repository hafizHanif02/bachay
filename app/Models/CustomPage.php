<?php

namespace App\Models;

use App\Models\CustomPageData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomPage extends Model
{
    use HasFactory;
    protected $table = 'custom_page';
    protected $fillable = [
        'title',
        'is_mobile',
        'is_web',
        'resource_type',
        'resource_id',
    ];

    public function page_data()
    {
        return $this->hasMany(CustomPageData::class,'custom_page_id');
    }
}
