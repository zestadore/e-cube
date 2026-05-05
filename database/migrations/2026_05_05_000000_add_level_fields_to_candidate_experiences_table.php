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
            // Industry level fields
            $table->unsignedBigInteger('industry_level_1')->nullable()->after('industry_id');
            $table->unsignedBigInteger('industry_level_2')->nullable()->after('industry_level_1');
            $table->unsignedBigInteger('industry_level_3')->nullable()->after('industry_level_2');
            
            // Role level fields
            $table->unsignedBigInteger('role_level_1')->nullable()->after('role_ids');
            $table->unsignedBigInteger('role_level_2')->nullable()->after('role_level_1');
            $table->unsignedBigInteger('role_level_3')->nullable()->after('role_level_2');
            $table->unsignedBigInteger('role_level_4')->nullable()->after('role_level_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_experiences', function (Blueprint $table) {
            $table->dropColumn([
                'industry_level_1',
                'industry_level_2',
                'industry_level_3',
                'role_level_1',
                'role_level_2',
                'role_level_3',
                'role_level_4',
            ]);
        });
    }
};