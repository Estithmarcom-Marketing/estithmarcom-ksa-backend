<?php

use App\Enum\MessageStatusEnum;
use App\Enum\RequestResidencyStatusEnum;
use App\Enum\RequestServiceStatusEnum;
use App\Events\ChatbotMessageSubmitted;
use App\Events\ContactMessageSubmitted;
use App\Events\ResidencyRequested;
use App\Events\ServiceRequested;
use App\Models\ContactUs;
use App\Models\Country;
use App\Models\Message;
use App\Models\RequestResidency;
use App\Models\RequestService;
use App\Models\Service;
use App\Models\User;
use App\Services\V1\SMS\TqnyatSmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\mock;

uses(RefreshDatabase::class);

it('sends an sms to admins with a phone when an event is dispatched', function (Closure $createEvent, string $expectedMessage) {
    $admin = User::factory()->create(['phone' => '966512345678']);
    $otherAdmin = User::factory()->create(['phone' => '966559876543']);
    User::factory()->create(['phone' => null]);

    mock(TqnyatSmsService::class)
        ->shouldReceive('send')
        ->once()
        ->with(['966512345678', '966559876543'], $expectedMessage);

    event($createEvent());
})->with([
    'chatbot message' => [
        fn () => new ChatbotMessageSubmitted(Message::create([
            'name' => 'أحمد',
            'phone' => '966500000000',
            'details' => 'مرحبا',
            'status' => MessageStatusEnum::PENDING,
            'service' => [],
        ])),
        'رسالة جديدة من البوت - أحمد',
    ],
    'contact message' => [
        fn () => new ContactMessageSubmitted(ContactUs::create([
            'name' => 'محمد',
            'phone' => '966500000000',
            'email' => 'mohamed@example.com',
            'message' => 'مرحبا',
            'contacted' => false,
        ])),
        'رسالة تواصل جديدة من محمد',
    ],
    'residency requested' => [
        fn () => new ResidencyRequested(RequestResidency::create([
            'name' => 'خالد',
            'phone' => '966500000000',
            'city' => 'الرياض',
            'status' => RequestResidencyStatusEnum::PENDING,
        ])),
        'طلب إقامة جديد من خالد',
    ],
    'service requested' => [
        fn () => new ServiceRequested(RequestService::create([
            'name' => 'سارة',
            'phone' => '966500000000',
            'service_id' => Service::create([
                'title_ar' => 'خدمة',
                'title_en' => 'Service',
                'slug_ar' => 'khedma',
                'slug_en' => 'service',
                'short_description_ar' => 'وصف',
                'short_description_en' => 'Description',
                'long_description_ar' => 'وصف طويل',
                'long_description_en' => 'Long description',
            ])->id,
            'country_id' => Country::create([
                'name_ar' => 'السعودية',
                'name_en' => 'Saudi Arabia',
                'title_ar' => 'السعودية',
                'title_en' => 'Saudi Arabia',
                'description_ar' => 'وصف',
                'description_en' => 'Description',
            ])->id,
            'status' => RequestServiceStatusEnum::PENDING,
        ])),
        'طلب خدمة جديد من سارة',
    ],
]);

it('does not send an sms when no admin has a phone', function () {
    User::factory()->create(['phone' => null]);

    mock(TqnyatSmsService::class)
        ->shouldNotReceive('send');

    event(new ChatbotMessageSubmitted(Message::create([
        'name' => 'أحمد',
        'phone' => '966500000000',
        'details' => 'مرحبا',
        'status' => MessageStatusEnum::PENDING,
        'service' => [],
    ])));
});
