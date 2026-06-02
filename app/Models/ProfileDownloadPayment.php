<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileDownloadPayment extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'status',
        'transaction_id',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'response_data' => 'array',
        'paid_at' => 'datetime',
    ];

    /**
     * Check if user has paid for profile download
     */
    public static function hasPaid($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', 'completed')
            ->exists();
    }

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}