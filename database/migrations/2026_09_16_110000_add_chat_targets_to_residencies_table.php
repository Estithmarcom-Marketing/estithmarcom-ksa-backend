<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const CHAT_TARGETS = [
        'إقامة-مميزة-لمستثمر-أعمال' => 'EST-PR-GENERAL-005',
        'إقامة-مميزة-لمالك-عقار' => 'EST-PR-GENERAL-003',
        'إقامة-مميزة-لرائد-أعمال' => 'EST-PR-GENERAL-004',
        'إقامة-مميزة-للموهبة' => 'EST-PR-GENERAL-002',
        'إقامة-مميزة-للكفاءة-الاستثنائية' => 'EST-PR-GENERAL-001',
        'إقامة-مميزة-محددة-المدة' => 'EST-PR-GENERAL-006',
        'إقامة-مميزة-غير-محددة-المدة' => 'EST-PR-GENERAL-007',
    ];

    public function up(): void
    {
        Schema::table('residencies', function (Blueprint $table) {
            $table
                ->string('chat_target_type', 16)
                ->nullable()
                ->after('published');

            $table
                ->string('chat_target_id', 128)
                ->nullable()
                ->after('chat_target_type');
        });

        foreach (self::CHAT_TARGETS as $slug => $targetId) {
            DB::table('residencies')
                ->where('slug_ar', $slug)
                ->update([
                    'chat_target_type' => 'service',
                    'chat_target_id' => $targetId,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('residencies', function (Blueprint $table) {
            $table->dropColumn([
                'chat_target_type',
                'chat_target_id',
            ]);
        });
    }
};
