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

    public function roles()
    {
        return $this->belongsToJson(Industry::class, 'role_ids', 'id');
    }

}
