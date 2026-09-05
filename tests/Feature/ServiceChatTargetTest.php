<?php

use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use App\Http\Resources\Admin\Service\ServiceResource as AdminServiceResource;
use App\Http\Resources\Website\Service\ServiceResource as WebsiteServiceResource;
use App\Models\Service;
use App\Services\V1\Website\Service\ServiceManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

uses(RefreshDatabase::class);

function createChatTargetService(array $attributes = []): Service
{
    static $sequence = 0;

    $sequence++;

    return Service::query()->create(array_merge([
        'title_ar' => "خدمة اختبار {$sequence}",
        'title_en' => "Test Service {$sequence}",
        'slug_ar' => "test-service-ar-{$sequence}",
        'slug_en' => "test-service-en-{$sequence}",
        'short_description_ar' => 'وصف مختصر',
        'short_description_en' => 'Short description',
        'long_description_ar' => 'وصف طويل',
        'long_description_en' => 'Long description',
        'published' => true,
    ], $attributes));
}

function chatTargetStoreValidator(array $data)
{
    $rules = (new StoreServiceRequest)->rules();

    $chatRules = array_intersect_key(
        $rules,
        array_flip([
            'chat_target_type',
            'chat_target_id',
        ]),
    );

    return ValidatorFacade::make($data, $chatRules);
}

function chatTargetUpdateValidator(Service $service, array $data)
{
    $request = UpdateServiceRequest::create(
        "/admin/services/{$service->id}",
        'PATCH',
        $data,
    );

    $request->setRouteResolver(fn () => new class($service)
    {
        public function __construct(private Service $service) {}

        public function parameter(string $key, mixed $default = null): mixed
        {
            return $key === 'service'
                ? $this->service
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

it('adds the nullable chat target columns to services', function () {
    expect(Schema::hasColumns('services', [
        'chat_target_type',
        'chat_target_id',
    ]))->toBeTrue();
});

it('allows a service without a chat target', function () {
    expect(chatTargetStoreValidator([])->passes())->toBeTrue();
});

it('accepts each approved chat target type', function (
    string $targetType,
    string $targetId,
) {
    $validator = chatTargetStoreValidator([
        'chat_target_type' => $targetType,
        'chat_target_id' => $targetId,
    ]);

    expect($validator->passes())->toBeTrue();
})->with([
    ['category', 'company-formation'],
    ['group', 'marketing-business-development'],
    ['service', 'EST-MKT-BIZDEV-001'],
]);

it('requires chat target type and ID together', function (
    array $data,
    string $expectedError,
) {
    $validator = chatTargetStoreValidator($data);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has($expectedError))->toBeTrue();
})->with([
    [
        ['chat_target_id' => 'company-formation'],
        'chat_target_type',
    ],
    [
        ['chat_target_type' => 'category'],
        'chat_target_id',
    ],
]);

it('rejects unknown target types and malformed target IDs', function (
    array $data,
    string $expectedError,
) {
    $validator = chatTargetStoreValidator($data);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has($expectedError))->toBeTrue();
})->with([
    [
        [
            'chat_target_type' => 'unknown',
            'chat_target_id' => 'company-formation',
        ],
        'chat_target_type',
    ],
    [
        [
            'chat_target_type' => 'category',
            'chat_target_id' => '../company-formation',
        ],
        'chat_target_id',
    ],
    [
        [
            'chat_target_type' => 'group',
            'chat_target_id' => 'marketing business development',
        ],
        'chat_target_id',
    ],
]);

it('prevents partially clearing an existing chat target', function () {
    $service = createChatTargetService([
        'chat_target_type' => 'category',
        'chat_target_id' => 'company-formation',
    ]);

    $validator = chatTargetUpdateValidator($service, [
        'chat_target_type' => null,
    ]);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('chat_target_type'))->toBeTrue()
        ->and($validator->errors()->has('chat_target_id'))->toBeTrue();
});

it('allows clearing both chat target fields together', function () {
    $service = createChatTargetService([
        'chat_target_type' => 'category',
        'chat_target_id' => 'company-formation',
    ]);

    $validator = chatTargetUpdateValidator($service, [
        'chat_target_type' => null,
        'chat_target_id' => null,
    ]);

    expect($validator->passes())->toBeTrue();
});

it('persists chat target fields through service mass assignment', function () {
    $service = createChatTargetService([
        'chat_target_type' => 'group',
        'chat_target_id' => 'feasibility-study',
    ])->fresh();

    expect($service->chat_target_type)->toBe('group')
        ->and($service->chat_target_id)->toBe('feasibility-study');
});

it('exposes chat target fields through admin and website resources', function () {
    $service = createChatTargetService([
        'chat_target_type' => 'service',
        'chat_target_id' => 'EST-MKT-BIZDEV-001',
    ]);

    $request = Request::create('/', 'GET');

    $adminData = (new AdminServiceResource($service))->resolve($request);
    $websiteData = (new WebsiteServiceResource($service))->resolve($request);

    expect($adminData['chat_target_type'])->toBe('service')
        ->and($adminData['chat_target_id'])->toBe('EST-MKT-BIZDEV-001')
        ->and($websiteData['chat_target_type'])->toBe('service')
        ->and($websiteData['chat_target_id'])->toBe('EST-MKT-BIZDEV-001');
});

it('selects chat target fields in all website service queries', function () {
    app()->setLocale('en');

    $service = createChatTargetService([
        'chat_target_type' => 'group',
        'chat_target_id' => 'marketing-business-development',
    ]);

    $manager = app(ServiceManager::class);

    $listedService = collect(
        $manager->list(['per_page' => 10])->items(),
    )->firstWhere('id', $service->id);

    $shownService = $manager->show($service->id);

    $unpaginatedService = $manager
        ->listWithoutPagination()
        ->firstWhere('id', $service->id);

    expect($listedService)->not->toBeNull()
        ->and($listedService->chat_target_type)->toBe('group')
        ->and($listedService->chat_target_id)
        ->toBe('marketing-business-development')
        ->and($shownService)->not->toBeNull()
        ->and($shownService->chat_target_type)->toBe('group')
        ->and($shownService->chat_target_id)
        ->toBe('marketing-business-development')
        ->and($unpaginatedService)->not->toBeNull()
        ->and($unpaginatedService->chat_target_type)->toBe('group')
        ->and($unpaginatedService->chat_target_id)
        ->toBe('marketing-business-development');
});
