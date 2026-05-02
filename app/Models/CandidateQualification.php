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

    public function level1Qualification()
    {
        return $this->belongsTo(Qualification::class, 'level_1_qualification_id', 'id');
    }

    public function level2Qualification()
    {
        return $this->belongsTo(Qualification::class, 'level_2_qualification_id', 'id');
    }

    public function level3Qualification()
    {
        return $this->belongsTo(Qualification::class, 'level_3_qualification_id', 'id');
    }

    public function level4Qualification()
    {
        return $this->belongsTo(Qualification::class, 'level_4_qualification_id', 'id');
    }
}
