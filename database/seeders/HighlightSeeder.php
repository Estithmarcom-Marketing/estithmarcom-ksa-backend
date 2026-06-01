<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $highlights = [
            [
                'label_en' => 'WORLDWIDE BUSINESS',
                'label_ar' => 'الأعمال العالمية',
                'value_en' => '8000',
                'value_ar' => '8000',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'label_en' => 'SATISFIED CLIENTS',
                'label_ar' => 'العملاء الراضون',
                'value_en' => '1000',
                'value_ar' => '1000',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'label_en' => 'COUNTRIES SERVED',
                'label_ar' => 'الدول المخدومة',
                'value_en' => '7',
                'value_ar' => '7',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'label_en' => 'AWARD WINNING',
                'label_ar' => 'الجوائز الفائزة',
                'value_en' => '25',
                'value_ar' => '25',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('highlights')->insert($highlights);
    }
}
