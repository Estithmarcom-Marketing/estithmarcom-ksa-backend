<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')
            ->whereNotNull('address')
            ->orderBy('id')
            ->chunkById(100, function ($settings) {
                foreach ($settings as $setting) {
                    DB::table('addresses')->insert([
                        'setting_id' => $setting->id,
                        'address_ar' => $setting->address,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     *
     * Intentionally irreversible: copied rows are indistinguishable from
     * admin-created addresses, so no rollback is attempted.
     */
    public function down(): void
    {
        //
    }
};
