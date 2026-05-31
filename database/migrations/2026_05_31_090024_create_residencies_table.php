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
        Schema::create('residencies', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('slug_ar')->unique();
            $table->string('slug_en')->unique();
            $table->boolean('published')->default(false);
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('residencies');
    }
};
