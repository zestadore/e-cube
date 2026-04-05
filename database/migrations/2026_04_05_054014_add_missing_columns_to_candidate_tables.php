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
        // Add missing columns to candidate_qualifications
        Schema::table('candidate_qualifications', function (Blueprint $table) {
            if (!Schema::hasColumn('candidate_qualifications', 'institution')) {
                $table->string('institution')->nullable()->after('qualification_id');
            }
            if (!Schema::hasColumn('candidate_qualifications', 'college')) {
                $table->string('college')->nullable()->after('institution');
            }
        });

        // Add missing columns to candidate_skills
        Schema::table('candidate_skills', function (Blueprint $table) {
            if (!Schema::hasColumn('candidate_skills', 'proficiency')) {
                $table->string('proficiency')->default('Beginner')->after('skill_id');
            }
            if (Schema::hasColumn('candidate_skills', 'university')) {
                $table->dropColumn('university');
            }
            if (Schema::hasColumn('candidate_skills', 'from_year')) {
                $table->dropColumn('from_year');
            }
            if (Schema::hasColumn('candidate_skills', 'to_year')) {
                $table->dropColumn('to_year');
            }
            if (Schema::hasColumn('candidate_skills', 'percentage')) {
                $table->dropColumn('percentage');
            }
        });

        // Add missing columns to candidate_experiences
        Schema::table('candidate_experiences', function (Blueprint $table) {
            if (!Schema::hasColumn('candidate_experiences', 'location')) {
                $table->string('location')->nullable()->after('company');
            }
            if (!Schema::hasColumn('candidate_experiences', 'responsibilities')) {
                $table->text('responsibilities')->nullable()->after('duration');
            }
            if (!Schema::hasColumn('candidate_experiences', 'achievements')) {
                $table->text('achievements')->nullable()->after('responsibilities');
            }
            if (!Schema::hasColumn('candidate_experiences', 'present_salary')) {
                $table->decimal('present_salary', 12, 2)->nullable()->after('achievements');
            }
            if (!Schema::hasColumn('candidate_experiences', 'expected_salary')) {
                $table->decimal('expected_salary', 12, 2)->nullable()->after('present_salary');
            }
            if (!Schema::hasColumn('candidate_experiences', 'is_current')) {
                $table->boolean('is_current')->default(false)->after('expected_salary');
            }
            if (!Schema::hasColumn('candidate_experiences', 'display_order')) {
                $table->integer('display_order')->default(0)->after('is_current');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_qualifications', function (Blueprint $table) {
            $table->dropColumn(['institution', 'college']);
        });

        Schema::table('candidate_skills', function (Blueprint $table) {
            $table->dropColumn('proficiency');
            $table->string('university')->nullable();
            $table->year('from_year')->nullable();
            $table->year('to_year')->nullable();
            $table->integer('percentage')->nullable();
        });

        Schema::table('candidate_experiences', function (Blueprint $table) {
            $table->dropColumn(['location', 'responsibilities', 'achievements', 'present_salary', 'expected_salary', 'is_current', 'display_order']);
        });
    }
};