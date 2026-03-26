<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name_ar' => 'مصر',
                'name_en' => 'Egypt',
                'title_ar' => 'لماذا مصر؟',
                'title_en' => 'Why Egypt?',
                'description_ar' => 'سوق متنوع ودعم شامل لتأسيس الأعمال وتعزيز الاستثمارات.',
                'description_en' => 'A diverse market with comprehensive support for business establishment and investment growth.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'السعودية',
                'name_en' => 'Saudi Arabia',
                'title_ar' => 'لماذا السعودية؟',
                'title_en' => 'Why Saudi Arabia?',
                'description_ar' => 'اقتصاد قوي وفرص استثمارية مدعومة برؤية طموحة.',
                'description_en' => 'A strong economy with investment opportunities driven by a visionary future.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الإمارات',
                'name_en' => 'UAE',
                'title_ar' => 'لماذا الإمارات؟',
                'title_en' => 'Why UAE?',
                'description_ar' => 'بيئة أعمال عالمية وبنية تحتية متطورة لدعم النمو.',
                'description_en' => 'A global business environment with advanced infrastructure for growth.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'قطر',
                'name_en' => 'Qatar',
                'title_ar' => 'لماذا قطر؟',
                'title_en' => 'Why Qatar?',
                'description_ar' => 'اقتصاد مستقر وفرص استثمارية واعدة في مختلف القطاعات.',
                'description_en' => 'A stable economy with promising investment opportunities across sectors.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الكويت',
                'name_en' => 'Kuwait',
                'title_ar' => 'لماذا الكويت؟',
                'title_en' => 'Why Kuwait?',
                'description_ar' => 'موقع استراتيجي وبيئة داعمة للأعمال والاستثمار.',
                'description_en' => 'A strategic location with a supportive business and investment environment.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'المغرب',
                'name_en' => 'Morocco',
                'title_ar' => 'لماذا المغرب؟',
                'title_en' => 'Why Morocco?',
                'description_ar' => 'بوابة إلى أفريقيا مع فرص استثمارية متنوعة.',
                'description_en' => 'A gateway to Africa with diverse investment opportunities.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الأردن',
                'name_en' => 'Jordan',
                'title_ar' => 'لماذا الأردن؟',
                'title_en' => 'Why Jordan?',
                'description_ar' => 'بيئة مستقرة وداعمة لنمو الأعمال والاستثمارات.',
                'description_en' => 'A stable and supportive environment for business and investment growth.',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}
