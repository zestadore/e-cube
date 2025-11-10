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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('company_address');
            $table->string('company_website')->nullable();
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('company_description')->nullable();
            $table->date('date_of_establishment')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('chairman_name')->nullable();
            $table->string('chairman_contact')->nullable();
            $table->string('hr_name');
            $table->string('hr_contact');
            $table->string('registration_type')->comment('pvt_ltd, public_ltd, others');
            $table->integer('no_of_employees')->default(1);
            $table->foreignId('industry_id')->constrained('industries')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
