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
        Schema::create('content_texts', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index(); // home | about | services | jobs | register | contact | privacy | global | footer
            $table->string('key'); // dot-notation field key, e.g. hero.title
            $table->string('label')->nullable();
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // text | textarea | richtext | image | url
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['page', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_texts');
    }
};
