<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'user_id',
        'industry_id',
        'description',
        'parent_qualification_id',
        'qualification_id',
        'application_start_date',
        'application_end_date',
        'expiry_date',
        'status'
    ];

    protected $casts = [
        'application_start_date' => 'date',
        'application_end_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    public function parentQualification()
    {
        return $this->belongsTo(Qualification::class, 'parent_qualification_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}