<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $categories = [
            [
                'name_ar' => 'تأسيس الشركات',
                'name_en' => 'Company Formation',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name_ar' => 'استثمار',
                'name_en' => 'Investment',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name_ar' => 'الخدمات الحكومية',
                'name_en' => 'Government Services',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('categories')->insert($categories);
    }
}
