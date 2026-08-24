<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('address')->nullable();
        });

        DB::table('settings')
            ->orderBy('id')
            ->chunkById(100, function ($settings) {
                foreach ($settings as $setting) {
                    $address = DB::table('addresses')
                        ->where('setting_id', $setting->id)
                        ->orderBy('id')
                        ->value('address_ar');

                    if ($address !== null) {
                        DB::table('settings')
                            ->where('id', $setting->id)
                            ->update(['address' => $address]);
                    }
                }
            });
    }
};
