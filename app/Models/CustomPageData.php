<?php

namespace App\Models;

use App\Models\CustomPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomPageData extends Model
{
    use HasFactory;
    protected $table = 'custom_page_data';
    protected $fillable = [
        'custom_page_id',
        'image',
        'filter_data',
        'width',
        'margin_bottom',
        'margin_right',
    ];


    public function custom_page()
    {
        return $this->belongsTo(CustomPage::class, 'custom_page_id');
    }
}
