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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('slug_ar')->unique();
            $table->string('slug_en')->unique();
            $table->text('short_description_en');
            $table->text('short_description_ar');
            $table->text('long_description_en');
            $table->text('long_description_ar');
            $table->text('feature_description_ar')->nullable()->default(null);
            $table->text('feature_description_en')->nullable()->default(null);
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
        Schema::dropIfExists('services');
    }
};
