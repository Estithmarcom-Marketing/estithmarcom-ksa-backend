<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticPage;
use Illuminate\Support\Facades\DB;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages =
            [
                [
                    'slug_en' => 'privacy-policy',
                    'slug_ar' => 'سياسة-الخصوصية',
                    'title_en' => 'Privacy Policy',
                    'title_ar' => 'سياسة الخصوصية',
                    'content_en' => 'This is the Privacy Policy page content. Explain how you collect and use user data.',
                    'content_ar' => 'هذه صفحة سياسة الخصوصية. وضّح كيف يتم جمع واستخدام بيانات المستخدم.',
                    'meta_title_en' => 'Privacy Policy',
                    'meta_title_ar' => 'سياسة الخصوصية',
                    'meta_description_en' => 'Read our privacy policy.',
                    'meta_description_ar' => 'اقرأ سياسة الخصوصية الخاصة بنا.',
                ]
            ];
        DB::table('static_pages')->insert($pages);
    }
}
