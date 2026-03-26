<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [

            [
                'title_ar' => 'أهمية الاستثمار في السوق السعودي',
                'title_en' => 'The Importance of Investing in the Saudi Market',

                'subtitle_ar' => 'فرص نمو واعدة للمستثمرين',
                'subtitle_en' => 'Promising Growth Opportunities for Investors',

                'slug_ar' => 'اهمية-الاستثمار-في-السوق-السعودي',
                'slug_en' => 'importance-of-investing-in-saudi-market',

                'short_content_ar' => 'تعرف على أهم الفرص الاستثمارية المتاحة في المملكة العربية السعودية.',
                'short_content_en' => 'Discover the most important investment opportunities available in Saudi Arabia.',

                'content_ar' => 'يشهد السوق السعودي تطوراً اقتصادياً كبيراً مدعوماً برؤية المملكة 2030، مما يجعله وجهة جاذبة للمستثمرين المحليين والدوليين...',
                'content_en' => 'The Saudi market is experiencing major economic growth supported by Vision 2030, making it an attractive destination for local and international investors...',

                'published' => true,

                'meta_title_ar' => 'الاستثمار في السعودية',
                'meta_title_en' => 'Investing in Saudi Arabia',

                'meta_description_ar' => 'دليل شامل حول فرص الاستثمار في السوق السعودي.',
                'meta_description_en' => 'A comprehensive guide to investment opportunities in Saudi Arabia.',

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title_ar' => 'كيف تبدأ مشروعك التجاري بنجاح',
                'title_en' => 'How to Start a Successful Business',

                'subtitle_ar' => 'خطوات عملية لرواد الأعمال',
                'subtitle_en' => 'Practical Steps for Entrepreneurs',

                'slug_ar' => 'كيف-تبدأ-مشروعك-التجاري',
                'slug_en' => 'how-to-start-successful-business',

                'short_content_ar' => 'دليل مبسط لبدء مشروع تجاري ناجح من الفكرة وحتى التنفيذ.',
                'short_content_en' => 'A simple guide to launching a successful business from idea to execution.',

                'content_ar' => 'يبدأ نجاح أي مشروع بدراسة السوق ووضع خطة عمل واضحة تشمل الأهداف والاستراتيجيات المالية والتسويقية...',
                'content_en' => 'Every successful business begins with market research and a clear business plan covering goals, financial strategy, and marketing approach...',

                'published' => true,

                'meta_title_ar' => 'بدء مشروع تجاري',
                'meta_title_en' => 'Starting a Business',

                'meta_description_ar' => 'تعلم كيفية تأسيس مشروعك التجاري بطريقة احترافية.',
                'meta_description_en' => 'Learn how to establish your business professionally.',

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title_ar' => 'أفضل استراتيجيات تطوير الأعمال',
                'title_en' => 'Best Business Development Strategies',

                'subtitle_ar' => 'نمو مستدام للشركات',
                'subtitle_en' => 'Sustainable Company Growth',

                'slug_ar' => 'استراتيجيات-تطوير-الاعمال',
                'slug_en' => 'best-business-development-strategies',

                'short_content_ar' => 'استراتيجيات حديثة تساعد الشركات على تحقيق نمو مستدام.',
                'short_content_en' => 'Modern strategies that help companies achieve sustainable growth.',

                'content_ar' => 'يعتمد تطوير الأعمال على الابتكار وتحليل البيانات وبناء علاقات استراتيجية طويلة الأمد مع العملاء والشركاء...',
                'content_en' => 'Business development depends on innovation, data analysis, and building long-term strategic relationships with clients and partners...',

                'published' => true,

                'meta_title_ar' => 'تطوير الأعمال',
                'meta_title_en' => 'Business Development',

                'meta_description_ar' => 'أفضل طرق تطوير الأعمال وزيادة النمو المؤسسي.',
                'meta_description_en' => 'Top methods for business development and organizational growth.',

                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        DB::table('blogs')->insert($blogs);
    }
}
