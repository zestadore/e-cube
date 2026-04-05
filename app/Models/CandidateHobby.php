<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateHobby extends Model
{
    protected $table = 'candidate_hobbies';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}