<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('candidate_experiences', function (Blueprint $table) {
            $table->unsignedBigInteger('job_role_id')->nullable()->after('industry_id');
            $table->foreign('job_role_id')->references('id')->on('industries')->onDelete('set null');
            $table->index('job_role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_experiences', function (Blueprint $table) {
            $table->dropForeign(['job_role_id']);
            $table->dropIndex(['job_role_id']);
            $table->dropColumn('job_role_id');
        });
    }
};