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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->string('shift')->nullable();
            $table->string('pay')->nullable();
            $table->string('summary', 600)->nullable();
            $table->longText('description')->nullable();
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();
            $table->string('status')->default('open'); // open | closed | draft
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
