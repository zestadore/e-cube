<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerAndOtherSkill extends Model
{
    protected $table = 'computer_and_other_skills';
    protected $guarded = [];

    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }
    
}