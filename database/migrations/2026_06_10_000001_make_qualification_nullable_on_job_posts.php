<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Required qualification was removed from the job-post flow, so new posts
     * no longer set qualification_id. Make it nullable (parent_qualification_id
     * is already nullable). Columns are kept rather than dropped to preserve
     * existing data; raw SQL is used to avoid the doctrine/dbal requirement.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE job_posts MODIFY qualification_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE job_posts MODIFY qualification_id BIGINT UNSIGNED NOT NULL');
    }
};
