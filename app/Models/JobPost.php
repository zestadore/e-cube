<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'user_id',
        'industry_id',
        'description',
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

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
