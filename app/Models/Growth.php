<?php

namespace App\Models;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\familyRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Growth extends Model
{
    use HasFactory;
    protected $table = 'growth';
    protected $fillable = [
        'user_id',
        'child_id',
        'vaccination_id',
        'head_circle',
        'height',
        'weight',   
    ];

    public function vaccination(){
        return $this->belongsTo(Vaccination::class, 'vaccination_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function child(){
        return $this->belongsTo(familyRelation::class, 'child_id', 'id');
    }
}
