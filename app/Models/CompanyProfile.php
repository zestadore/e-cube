<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $guarded = [];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }
}
