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
        Schema::create('basic_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('dob');
            $table->string('gender');
            $table->string('alternate_mobile_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('alternate_email_id')->nullable();
            $table->string('aadhar_number');
            $table->string('pan_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('profession')->nullable();
            $table->string('experience')->comment('Fresher/Experienced');
            $table->string('Job_type')->comment('Part Time/Permanent');
            $table->string('differently_abled')->comment('Yes/No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_details');
    }
};
