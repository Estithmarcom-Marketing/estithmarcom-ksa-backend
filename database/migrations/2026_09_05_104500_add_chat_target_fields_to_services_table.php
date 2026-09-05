<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table
                ->string('chat_target_type', 16)
                ->nullable()
                ->after('published');

            $table
                ->string('chat_target_id', 128)
                ->nullable()
                ->after('chat_target_type');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'chat_target_type',
                'chat_target_id',
            ]);
        });
    }
};
