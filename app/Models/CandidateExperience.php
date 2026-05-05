<?php

namespace App\Models;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Illuminate\Database\Eloquent\Model;

class CandidateExperience extends Model
{
    protected $table = 'candidate_experiences';
    protected $guarded = [];
    use HasJsonRelationships;
    protected $casts = [
        'role_ids' => 'json', // or 'array'
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }

    // Industry level relationships
    public function industryLevel2()
    {
        return $this->belongsTo(Industry::class, 'industry_level_2', 'id');
    }

    public function industryLevel3()
    {
        return $this->belongsTo(Industry::class, 'industry_level_3', 'id');
    }

    public function roles()
    {
        return $this->belongsToJson(Industry::class, 'role_ids', 'id');
    }

    // Role level relationships
    public function roleLevel1()
    {
        return $this->belongsTo(Industry::class, 'role_level_1', 'id');
    }

    public function roleLevel2()
    {
        return $this->belongsTo(Industry::class, 'role_level_2', 'id');
    }

    public function roleLevel3()
    {
        return $this->belongsTo(Industry::class, 'role_level_3', 'id');
    }

    public function roleLevel4()
    {
        return $this->belongsTo(Industry::class, 'role_level_4', 'id');
    }

}
