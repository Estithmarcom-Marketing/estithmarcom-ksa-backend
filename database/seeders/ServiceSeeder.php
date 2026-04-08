<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $services = [
            [
                'title_en' => 'Establishment Services',
                'title_ar' => 'خدمات التأسيس',
                'slug_en' => 'establishment-services',
                'slug_ar' => 'خدمات-التأسيس',
                'short_description_en' => 'Company formation and business establishment services for investors and entrepreneurs.',
                'short_description_ar' => 'خدمات تأسيس الشركات والأعمال للمستثمرين ورواد الأعمال.',
                'long_description_en' => 'We provide comprehensive company formation services including legal setup, documentation, and full business establishment support.',
                'long_description_ar' => 'نقدم خدمات متكاملة لتأسيس الشركات تشمل الإجراءات القانونية والتوثيق والدعم الكامل لتأسيس الأعمال.',
                'meta_title_en' => 'Establishment Services',
                'meta_title_ar' => 'خدمات التأسيس',
                'meta_description_en' => 'Professional company formation and business establishment services.',
                'meta_description_ar' => 'خدمات احترافية لتأسيس الشركات والأعمال.',
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Administrative Services',
                'title_ar' => 'الخدمات الإدارية',
                'slug_en' => 'administrative-services',
                'slug_ar' => 'الخدمات-الإدارية',
                'short_description_en' => 'Professional administrative and operational business services.',
                'short_description_ar' => 'خدمات إدارية وتشغيلية احترافية للأعمال.',
                'long_description_en' => 'We offer administrative solutions to manage operations efficiently and support business growth.',
                'long_description_ar' => 'نقدم حلول إدارية لإدارة العمليات بكفاءة ودعم نمو الأعمال.',
                'meta_title_en' => 'Administrative Services',
                'meta_title_ar' => 'الخدمات الإدارية',
                'meta_description_en' => 'Professional administrative support services.',
                'meta_description_ar' => 'خدمات دعم إداري احترافية.',
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Marketing and Management Consulting',
                'title_ar' => 'استشارات التسويق والإدارة',
                'slug_en' => 'marketing-management-consulting',
                'slug_ar' => 'استشارات-التسويق-والإدارة',
                'short_description_en' => 'Strategic marketing and management consulting services.',
                'short_description_ar' => 'خدمات استشارية استراتيجية في التسويق والإدارة.',
                'long_description_en' => 'We help businesses grow through professional marketing strategies and management consulting.',
                'long_description_ar' => 'نساعد الشركات على النمو من خلال استراتيجيات تسويقية واستشارات إدارية احترافية.',
                'meta_title_en' => 'Marketing & Management Consulting',
                'meta_title_ar' => 'استشارات التسويق والإدارة',
                'meta_description_en' => 'Professional marketing and management consulting services.',
                'meta_description_ar' => 'خدمات استشارية احترافية في التسويق والإدارة.',
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Government Services & Licensing',
                'title_ar' => 'الخدمات الحكومية والتراخيص',
                'slug_en' => 'government-services-licensing',
                'slug_ar' => 'الخدمات-الحكومية-والتراخيص',
                'short_description_en' => 'Government approvals and licensing services.',
                'short_description_ar' => 'خدمات التراخيص والموافقات الحكومية.',
                'long_description_en' => 'We handle government procedures, approvals, and licensing for businesses.',
                'long_description_ar' => 'نتولى إجراءات التراخيص والموافقات الحكومية للشركات.',
                'meta_title_en' => 'Government Services & Licensing',
                'meta_title_ar' => 'الخدمات الحكومية والتراخيص',
                'meta_description_en' => 'Government licensing and approvals services.',
                'meta_description_ar' => 'خدمات التراخيص والموافقات الحكومية.',
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Business Space Management Services',
                'title_ar' => 'إدارة مساحات الأعمال',
                'slug_en' => 'business-space-management',
                'slug_ar' => 'إدارة-مساحات-الأعمال',
                'short_description_en' => 'Workspace and office management services.',
                'short_description_ar' => 'خدمات إدارة المكاتب ومساحات العمل.',
                'long_description_en' => 'We provide business space management solutions including offices and shared spaces.',
                'long_description_ar' => 'نقدم حلول إدارة مساحات الأعمال بما في ذلك المكاتب والمساحات المشتركة.',
                'meta_title_en' => 'Business Space Management',
                'meta_title_ar' => 'إدارة مساحات الأعمال',
                'meta_description_en' => 'Business workspace and office management services.',
                'meta_description_ar' => 'خدمات إدارة المكاتب ومساحات العمل.',
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Feasibility Studies',
                'title_ar' => 'دراسات الجدوى',
                'slug_en' => 'feasibility-studies',
                'slug_ar' => 'دراسات-الجدوى',
                'short_description_en' => 'Professional feasibility studies for business projects.',
                'short_description_ar' => 'دراسات جدوى احترافية للمشاريع.',
                'long_description_en' => 'We prepare detailed feasibility studies to evaluate business opportunities.',
                'long_description_ar' => 'نقوم بإعداد دراسات جدوى تفصيلية لتقييم فرص المشاريع.',
                'meta_title_en' => 'Feasibility Studies',
                'meta_title_ar' => 'دراسات الجدوى',
                'meta_description_en' => 'Professional business feasibility studies.',
                'meta_description_ar' => 'دراسات جدوى احترافية للمشاريع.',
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];
        DB::table('services')->insert($services);
    }
}
