<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSubmission extends Model
{
    use HasFactory;
    protected $table = 'vaccination_submission';
    protected $fillable = [
        'user_id',
        'child_id',
        'vaccination_id',
        'vaccination_date',
        'submission_date',
        'picture',
        'is_taken',
    ];

    public function vaccination()
    {
        return $this->belongsTo(Vaccination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function child()
    {
        return $this->belongsTo(familyRelation::class);
    }
}
