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
        Schema::table('candidate_qualifications', function (Blueprint $table) {
            // Add columns to track all qualification levels
            if (!Schema::hasColumn('candidate_qualifications', 'level_1_qualification_id')) {
                $table->foreignId('level_1_qualification_id')->nullable()->after('qualification_id')->constrained('qualifications')->onDelete('set null');
            }
            if (!Schema::hasColumn('candidate_qualifications', 'level_2_qualification_id')) {
                $table->foreignId('level_2_qualification_id')->nullable()->after('level_1_qualification_id')->constrained('qualifications')->onDelete('set null');
            }
            if (!Schema::hasColumn('candidate_qualifications', 'level_3_qualification_id')) {
                $table->foreignId('level_3_qualification_id')->nullable()->after('level_2_qualification_id')->constrained('qualifications')->onDelete('set null');
            }
            if (!Schema::hasColumn('candidate_qualifications', 'level_4_qualification_id')) {
                $table->foreignId('level_4_qualification_id')->nullable()->after('level_3_qualification_id')->constrained('qualifications')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_qualifications', function (Blueprint $table) {
            if (Schema::hasColumn('candidate_qualifications', 'level_1_qualification_id')) {
                $table->dropForeign(['level_1_qualification_id']);
                $table->dropColumn('level_1_qualification_id');
            }
            if (Schema::hasColumn('candidate_qualifications', 'level_2_qualification_id')) {
                $table->dropForeign(['level_2_qualification_id']);
                $table->dropColumn('level_2_qualification_id');
            }
            if (Schema::hasColumn('candidate_qualifications', 'level_3_qualification_id')) {
                $table->dropForeign(['level_3_qualification_id']);
                $table->dropColumn('level_3_qualification_id');
            }
            if (Schema::hasColumn('candidate_qualifications', 'level_4_qualification_id')) {
                $table->dropForeign(['level_4_qualification_id']);
                $table->dropColumn('level_4_qualification_id');
            }
        });
    }
};