<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsAgreement extends Model
{
    protected $table = 'terms_agreements';
    protected $guarded = [];

    protected $casts = [
        'agreed' => 'boolean',
        'agreed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}