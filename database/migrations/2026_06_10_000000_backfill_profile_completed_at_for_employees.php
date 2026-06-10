<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * profile_completed_at was never persisted before (missing from the User
     * $fillable), so existing employees who already finished their profile have
     * a NULL value. Treat any employee that already has a basic_details row as
     * completed so the new profile-completion gate does not lock them out.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'employee')
            ->whereNull('profile_completed_at')
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('basic_details');
            })
            ->update(['profile_completed_at' => now()]);
    }

    public function down(): void
    {
        // No-op: we cannot reliably distinguish backfilled rows from genuine ones.
    }
};
