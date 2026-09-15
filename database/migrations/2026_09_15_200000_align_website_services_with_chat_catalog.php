<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SERVICES = [
        'تأسيس-الشركات' => [
            'before_title_ar' => 'تأسيس الشركات',
            'title_ar' => 'تأسيس شركات',
            'before_target_type' => 'category',
            'before_target_id' => 'company-formation',
            'target_type' => 'category',
            'target_id' => 'company-formation',
        ],
        'خدمات-التسويق-ودراسة-الجدوى' => [
            'before_title_ar' => 'خدمات التسويق ودراسة الجدوى',
            'title_ar' => 'خدمات التسويق ودراسة الجدوى',
            'before_target_type' => 'category',
            'before_target_id' => 'legal-services',
            'target_type' => 'category',
            'target_id' => 'marketing-feasibility',
        ],
        'الإجراءات-الحكومية-والتعقيب' => [
            'before_title_ar' => 'الإجراءات الحكومية والتعقيب',
            'title_ar' => 'الإجراءات الحكومية وإدارة المنصات',
            'before_target_type' => 'category',
            'before_target_id' => 'government-procedures',
            'target_type' => 'category',
            'target_id' => 'government-procedures',
        ],
        'الإقامة-المميزة-والذهبية' => [
            'before_title_ar' => 'الإقامة المميزة والذهبية',
            'title_ar' => 'الإقامة المميزة والإقامة الذهبية',
            'before_target_type' => 'category',
            'before_target_id' => 'premium-residency',
            'target_type' => 'category',
            'target_id' => 'premium-residency',
        ],
        'مساحات-عمل-جاهزة-ومكاتب-مشتركة' => [
            'before_title_ar' => 'مساحات عمل جاهزة ومكاتب مشتركة',
            'title_ar' => 'استئجار مساحة عمل جاهزة',
            'before_target_type' => 'category',
            'before_target_id' => 'ready-workspaces',
            'target_type' => 'category',
            'target_id' => 'ready-workspaces',
        ],
        'التراخيص-الريادية-واحتضان-المشاريع' => [
            'before_title_ar' => 'التراخيص الريادية واحتضان المشاريع',
            'title_ar' => 'التراخيص الريادية واحتضان المشاريع',
            'before_target_type' => 'category',
            'before_target_id' => 'entrepreneurial-licenses',
            'target_type' => 'category',
            'target_id' => 'entrepreneurial-licenses',
        ],
        'الخدمات-القانونية' => [
            'before_title_ar' => 'الخدمات القانونية',
            'title_ar' => 'الخدمات القانونية',
            'before_target_type' => 'category',
            'before_target_id' => 'legal-services',
            'target_type' => 'category',
            'target_id' => 'legal-services',
        ],
        'الخدمات-المالية' => [
            'before_title_ar' => 'الخدمات المالية',
            'title_ar' => 'الخدمات المالية',
            'before_target_type' => 'group',
            'before_target_id' => 'financial-consultant',
            'target_type' => 'category',
            'target_id' => 'financial-services',
        ],
    ];

    public function up(): void
    {
        foreach (self::SERVICES as $slug => $service) {
            DB::table('services')
                ->where('slug_ar', $slug)
                ->update([
                    'title_ar' => $service['title_ar'],
                    'chat_target_type' => $service['target_type'],
                    'chat_target_id' => $service['target_id'],
                ]);
        }
    }

    public function down(): void
    {
        foreach (self::SERVICES as $slug => $service) {
            DB::table('services')
                ->where('slug_ar', $slug)
                ->where('title_ar', $service['title_ar'])
                ->where('chat_target_type', $service['target_type'])
                ->where('chat_target_id', $service['target_id'])
                ->update([
                    'title_ar' => $service['before_title_ar'],
                    'chat_target_type' => $service['before_target_type'],
                    'chat_target_id' => $service['before_target_id'],
                ]);
        }
    }
};
