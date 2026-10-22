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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('profession')->nullable();
            $table->string('locations')->nullable();
            $table->boolean('adult_confirmed')->default(false);
            $table->string('languages')->nullable();
            $table->text('skills')->nullable();
            $table->string('experience_years')->nullable();
            $table->string('disability_status')->default('prefer_not'); // yes | no | prefer_not
            $table->text('accommodation')->nullable();
            $table->boolean('sms_consent')->default(false);
            $table->string('resume_path')->nullable();
            $table->string('resume_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
