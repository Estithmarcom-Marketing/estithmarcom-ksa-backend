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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('subtitle_ar');
            $table->string('subtitle_en');
            $table->string('slug_ar')->unique();
            $table->string('slug_en')->unique();
            $table->string('short_content_ar');
            $table->string('short_content_en');
            $table->text('content_ar');
            $table->text('content_en');
            $table->boolean('published')->default(false);
            $table->string('meta_title_ar')->nullable()->default(null);
            $table->string('meta_title_en')->nullable()->default(null);
            $table->string('meta_description_ar')->nullable()->default(null);
            $table->string('meta_description_en')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
