<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeLayout extends Model
{

    protected $fillable = [
        'section_name',
        'web_order',
        'mobile_order',
        'web_status',
        'mobile_status',
    ];
    use HasFactory;
}
