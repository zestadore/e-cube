<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateViewPayment extends Model
{
    protected $fillable = [
        'employer_id',
        'candidate_id',
        'order_id',
        'transaction_id',
        'amount',
        'status',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'response_data' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Check if employer has paid for this candidate
     */
    public static function hasPaid($employerId, $candidateId)
    {
        return self::where('employer_id', $employerId)
            ->where('candidate_id', $candidateId)
            ->where('status', 'completed')
            ->exists();
    }
}