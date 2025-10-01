<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $table = 'qualifications';
    protected $guarded = [];

    public function parents()
    {
        return $this->belongsToMany(
            Qualification::class, 
            'qualification_parent', 
            'qualification_id', 
            'parent_id'
        );
    }

    public function children()
    {
        return $this->belongsToMany(
            Qualification::class, 
            'qualification_parent', 
            'parent_id', 
            'qualification_id'
        );
    }
}
