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
            $table->text('responsibilities')->nullable()->after('duration');
            $table->text('achievements')->nullable()->after('responsibilities');
            $table->decimal('present_salary', 12, 2)->nullable()->after('achievements');
            $table->decimal('expected_salary', 12, 2)->nullable()->after('present_salary');
            $table->boolean('is_current')->default(false)->after('expected_salary');
            $table->integer('display_order')->default(0)->after('is_current');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_experiences', function (Blueprint $table) {
            $table->dropColumn(['responsibilities', 'achievements', 'present_salary', 'expected_salary', 'is_current', 'display_order']);
        });
    }
};