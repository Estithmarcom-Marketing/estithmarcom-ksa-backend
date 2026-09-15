<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

function serviceChatCatalogAlignmentCases(): array
{
    return [
        [
            'id' => 1,
            'slug_ar' => 'تأسيس-الشركات',
            'before_title_ar' => 'تأسيس الشركات',
            'title_ar' => 'تأسيس شركات',
            'before_target_type' => 'category',
            'before_target_id' => 'company-formation',
            'target_type' => 'category',
            'target_id' => 'company-formation',
        ],
        [
            'id' => 2,
            'slug_ar' => 'خدمات-التسويق-ودراسة-الجدوى',
            'before_title_ar' => 'خدمات التسويق ودراسة الجدوى',
            'title_ar' => 'خدمات التسويق ودراسة الجدوى',
            'before_target_type' => 'category',
            'before_target_id' => 'legal-services',
            'target_type' => 'category',
            'target_id' => 'marketing-feasibility',
        ],
        [
            'id' => 3,
            'slug_ar' => 'الإجراءات-الحكومية-والتعقيب',
            'before_title_ar' => 'الإجراءات الحكومية والتعقيب',
            'title_ar' => 'الإجراءات الحكومية وإدارة المنصات',
            'before_target_type' => 'category',
            'before_target_id' => 'government-procedures',
            'target_type' => 'category',
            'target_id' => 'government-procedures',
        ],
        [
            'id' => 4,
            'slug_ar' => 'الإقامة-المميزة-والذهبية',
            'before_title_ar' => 'الإقامة المميزة والذهبية',
            'title_ar' => 'الإقامة المميزة والإقامة الذهبية',
            'before_target_type' => 'category',
            'before_target_id' => 'premium-residency',
            'target_type' => 'category',
            'target_id' => 'premium-residency',
        ],
        [
            'id' => 5,
            'slug_ar' => 'مساحات-عمل-جاهزة-ومكاتب-مشتركة',
            'before_title_ar' => 'مساحات عمل جاهزة ومكاتب مشتركة',
            'title_ar' => 'استئجار مساحة عمل جاهزة',
            'before_target_type' => 'category',
            'before_target_id' => 'ready-workspaces',
            'target_type' => 'category',
            'target_id' => 'ready-workspaces',
        ],
        [
            'id' => 7,
            'slug_ar' => 'التراخيص-الريادية-واحتضان-المشاريع',
            'before_title_ar' => 'التراخيص الريادية واحتضان المشاريع',
            'title_ar' => 'التراخيص الريادية واحتضان المشاريع',
            'before_target_type' => 'category',
            'before_target_id' => 'entrepreneurial-licenses',
            'target_type' => 'category',
            'target_id' => 'entrepreneurial-licenses',
        ],
        [
            'id' => 8,
            'slug_ar' => 'الخدمات-القانونية',
            'before_title_ar' => 'الخدمات القانونية',
            'title_ar' => 'الخدمات القانونية',
            'before_target_type' => 'category',
            'before_target_id' => 'legal-services',
            'target_type' => 'category',
            'target_id' => 'legal-services',
        ],
        [
            'id' => 9,
            'slug_ar' => 'الخدمات-المالية',
            'before_title_ar' => 'الخدمات المالية',
            'title_ar' => 'الخدمات المالية',
            'before_target_type' => 'group',
            'before_target_id' => 'financial-consultant',
            'target_type' => 'category',
            'target_id' => 'financial-services',
        ],
    ];
}

function insertServiceChatCatalogFixtures(): void
{
    $now = now();

    foreach (serviceChatCatalogAlignmentCases() as $service) {
        DB::table('services')->insert([
            'id' => $service['id'],
            'title_ar' => $service['before_title_ar'],
            'title_en' => "Service {$service['id']}",
            'slug_ar' => $service['slug_ar'],
            'slug_en' => "service-{$service['id']}",
            'short_description_ar' => 'وصف مختصر',
            'short_description_en' => 'Short description',
            'long_description_ar' => 'وصف طويل',
            'long_description_en' => 'Long description',
            'published' => true,
            'chat_target_type' => $service['before_target_type'],
            'chat_target_id' => $service['before_target_id'],
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}

function serviceChatCatalogMigration(): object
{
    return require database_path(
        'migrations/2026_09_15_200000_align_website_services_with_chat_catalog.php',
    );
}

it('aligns website service titles and targets with the chat catalog', function () {
    insertServiceChatCatalogFixtures();

    serviceChatCatalogMigration()->up();

    foreach (serviceChatCatalogAlignmentCases() as $expected) {
        $service = DB::table('services')
            ->where('id', $expected['id'])
            ->first();

        expect($service)->not->toBeNull()
            ->and($service->title_ar)->toBe($expected['title_ar'])
            ->and($service->title_en)->toBe("Service {$expected['id']}")
            ->and($service->slug_ar)->toBe($expected['slug_ar'])
            ->and($service->slug_en)->toBe("service-{$expected['id']}")
            ->and($service->chat_target_type)->toBe($expected['target_type'])
            ->and($service->chat_target_id)->toBe($expected['target_id']);
    }
});

it('restores the previous service titles and targets on rollback', function () {
    insertServiceChatCatalogFixtures();

    $migration = serviceChatCatalogMigration();
    $migration->up();
    $migration->down();

    foreach (serviceChatCatalogAlignmentCases() as $expected) {
        $service = DB::table('services')
            ->where('id', $expected['id'])
            ->first();

        expect($service)->not->toBeNull()
            ->and($service->title_ar)->toBe($expected['before_title_ar'])
            ->and($service->title_en)->toBe("Service {$expected['id']}")
            ->and($service->slug_ar)->toBe($expected['slug_ar'])
            ->and($service->slug_en)->toBe("service-{$expected['id']}")
            ->and($service->chat_target_type)->toBe($expected['before_target_type'])
            ->and($service->chat_target_id)->toBe($expected['before_target_id']);
    }
});
