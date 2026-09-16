<?php

use App\Http\Requests\Admin\Residency\StoreResidencyRequest;
use App\Http\Requests\Admin\Residency\UpdateResidencyRequest;
use App\Http\Resources\Admin\Residency\ResidencyResource as AdminResidencyResource;
use App\Http\Resources\Website\Residency\ResidencyResource as WebsiteResidencyResource;
use App\Models\Residency;
use App\Services\V1\Website\Residency\ResidencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

uses(RefreshDatabase::class);

function residencyChatTargetCases(): array
{
    return [
        ['إقامة-مميزة-لمستثمر-أعمال', 'EST-PR-GENERAL-005'],
        ['إقامة-مميزة-لمالك-عقار', 'EST-PR-GENERAL-003'],
        ['إقامة-مميزة-لرائد-أعمال', 'EST-PR-GENERAL-004'],
        ['إقامة-مميزة-للموهبة', 'EST-PR-GENERAL-002'],
        ['إقامة-مميزة-للكفاءة-الاستثنائية', 'EST-PR-GENERAL-001'],
        ['إقامة-مميزة-محددة-المدة', 'EST-PR-GENERAL-006'],
        ['إقامة-مميزة-غير-محددة-المدة', 'EST-PR-GENERAL-007'],
    ];
}

function createResidencyChatTargetFixture(array $attributes = []): Residency
{
    static $sequence = 0;

    $sequence++;

    return Residency::query()->create(array_merge([
        'title_ar' => "إقامة اختبار {$sequence}",
        'title_en' => "Test Residency {$sequence}",
        'description_ar' => 'وصف عربي',
        'description_en' => 'English description',
        'slug_ar' => "test-residency-ar-{$sequence}",
        'slug_en' => "test-residency-en-{$sequence}",
        'published' => true,
    ], $attributes));
}

function residencyChatStoreValidator(array $data)
{
    $rules = (new StoreResidencyRequest)->rules();

    return ValidatorFacade::make(
        $data,
        array_intersect_key(
            $rules,
            array_flip([
                'chat_target_type',
                'chat_target_id',
            ]),
        ),
    );
}

function residencyChatUpdateValidator(
    Residency $residency,
    array $data,
) {
    $request = UpdateResidencyRequest::create(
        "/admin/residencies/{$residency->id}",
        'PATCH',
        $data,
    );

    $request->setRouteResolver(fn () => new class($residency)
    {
        public function __construct(private Residency $residency) {}

        public function parameter(string $key, mixed $default = null): mixed
        {
            return $key === 'residency'
                ? $this->residency
                : $default;
        }
    });

    $validator = ValidatorFacade::make(
        $request->all(),
        $request->rules(),
    );

    $request->withValidator($validator);

    return $validator;
}

function residencyChatMigration(): object
{
    return require database_path(
        'migrations/2026_09_16_110000_add_chat_targets_to_residencies_table.php',
    );
}

function insertResidencyCatalogFixtures(): void
{
    $now = now();

    foreach (residencyChatTargetCases() as $index => [$slug, $targetId]) {
        DB::table('residencies')->insert([
            'title_ar' => "إقامة {$index}",
            'title_en' => "Residency {$index}",
            'description_ar' => 'وصف عربي',
            'description_en' => 'English description',
            'slug_ar' => $slug,
            'slug_en' => "residency-{$index}",
            'published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}

it('adds nullable chat target columns to residencies', function () {
    expect(Schema::hasColumns('residencies', [
        'chat_target_type',
        'chat_target_id',
    ]))->toBeTrue();
});

it('maps all seven website residencies to direct chat services', function () {
    $migration = residencyChatMigration();
    $migration->down();

    insertResidencyCatalogFixtures();
    $migration->up();

    foreach (residencyChatTargetCases() as [$slug, $targetId]) {
        $residency = DB::table('residencies')
            ->where('slug_ar', $slug)
            ->first();

        expect($residency)->not->toBeNull()
            ->and($residency->chat_target_type)->toBe('service')
            ->and($residency->chat_target_id)->toBe($targetId);
    }
});

it('preserves residency rows when the migration is rolled back', function () {
    $migration = residencyChatMigration();
    $migration->down();

    insertResidencyCatalogFixtures();
    $migration->up();
    $migration->down();

    expect(Schema::hasColumn('residencies', 'chat_target_type'))->toBeFalse()
        ->and(Schema::hasColumn('residencies', 'chat_target_id'))->toBeFalse()
        ->and(DB::table('residencies')->count())->toBe(7);
});

it('accepts valid targets and rejects invalid target data', function () {
    expect(residencyChatStoreValidator([
        'chat_target_type' => 'service',
        'chat_target_id' => 'EST-PR-GENERAL-005',
    ])->passes())->toBeTrue()
        ->and(residencyChatStoreValidator([
            'chat_target_type' => 'unknown',
            'chat_target_id' => 'EST-PR-GENERAL-005',
        ])->fails())->toBeTrue()
        ->and(residencyChatStoreValidator([
            'chat_target_type' => 'service',
        ])->fails())->toBeTrue()
        ->and(residencyChatStoreValidator([
            'chat_target_id' => '../invalid',
        ])->fails())->toBeTrue();
});

it('prevents partially clearing an existing residency target', function () {
    $residency = createResidencyChatTargetFixture([
        'chat_target_type' => 'service',
        'chat_target_id' => 'EST-PR-GENERAL-005',
    ]);

    $validator = residencyChatUpdateValidator($residency, [
        'chat_target_type' => null,
    ]);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('chat_target_type'))->toBeTrue()
        ->and($validator->errors()->has('chat_target_id'))->toBeTrue();
});

it('persists and exposes residency chat targets', function () {
    $residency = createResidencyChatTargetFixture([
        'chat_target_type' => 'service',
        'chat_target_id' => 'EST-PR-GENERAL-003',
    ])->fresh();

    $request = Request::create('/', 'GET');

    $adminData = (new AdminResidencyResource($residency))
        ->resolve($request);

    $websiteData = (new WebsiteResidencyResource($residency))
        ->resolve($request);

    expect($residency->chat_target_type)->toBe('service')
        ->and($residency->chat_target_id)->toBe('EST-PR-GENERAL-003')
        ->and($adminData['chat_target_type'])->toBe('service')
        ->and($adminData['chat_target_id'])->toBe('EST-PR-GENERAL-003')
        ->and($websiteData['chat_target_type'])->toBe('service')
        ->and($websiteData['chat_target_id'])->toBe('EST-PR-GENERAL-003');
});

it('selects chat targets in residency list and detail queries', function () {
    app()->setLocale('ar');

    $residency = createResidencyChatTargetFixture([
        'chat_target_type' => 'service',
        'chat_target_id' => 'EST-PR-GENERAL-001',
    ]);

    $service = app(ResidencyService::class);

    $listedResidency = collect(
        $service->list(['per_page' => 10])->items(),
    )->firstWhere('id', $residency->id);

    $shownResidency = $service->show($residency->id);

    expect($listedResidency)->not->toBeNull()
        ->and($listedResidency->chat_target_type)->toBe('service')
        ->and($listedResidency->chat_target_id)
        ->toBe('EST-PR-GENERAL-001')
        ->and($shownResidency)->not->toBeNull()
        ->and($shownResidency->chat_target_type)->toBe('service')
        ->and($shownResidency->chat_target_id)
        ->toBe('EST-PR-GENERAL-001');
});
