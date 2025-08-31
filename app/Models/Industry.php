<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industries';
    protected $guarded = [];

    public function parents()
    {
        return $this->belongsToMany(
            Industry::class, 
            'industry_parent', 
            'industry_id', 
            'parent_id'
        );
    }

    public function children()
    {
        return $this->belongsToMany(
            Industry::class, 
            'industry_parent', 
            'parent_id', 
            'industry_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
