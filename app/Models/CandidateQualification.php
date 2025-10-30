<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateQualification extends Model
{
    protected $table = 'candidate_qualifications';
    protected $guarded = [];

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'qualification_id', 'id');
    }
}
