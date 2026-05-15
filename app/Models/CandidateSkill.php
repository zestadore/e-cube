<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateSkill extends Model
{
    protected $table = 'candidate_skills';
    protected $guarded = [];

    public function skill()
    {
        return $this->belongsTo(ComputerAndOtherSkill::class, 'skill_id', 'id')->with('industry');
    }
}
