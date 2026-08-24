<?php

use App\Models\Address;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function actingAsSettingAdmin(User $user): User
{
    Sanctum::actingAs($user);
    auth('api')->setUser($user);

    return $user;
}

function createSettingWithAddresses(int $count = 2): Setting
{
    $setting = Setting::factory()->create();
    $setting->addresses()->createMany(Address::factory()->count($count)->make()->toArray());

    return $setting;
}

it('lists admin settings with all address translations', function () {
    actingAsSettingAdmin(User::factory()->create());
    $setting = createSettingWithAddresses();

    $this->getJson('/api/v1/admin/settings')
        ->assertSuccessful()
        ->assertJsonPath('data.settings.addresses.0.address_ar', $setting->addresses->first()->address_ar)
        ->assertJsonPath('data.settings.addresses.0.address_en', $setting->addresses->first()->address_en);
});

it('replaces all addresses when addresses are sent on update', function () {
    actingAsSettingAdmin(User::factory()->create());
    $setting = createSettingWithAddresses();
    $oldAddressEn = $setting->addresses()->first()->address_en;

    $this->patchJson('/api/v1/admin/settings', [
        'addresses' => [
            ['address_ar' => 'جدة - المملكة العربية السعودية', 'address_en' => 'Jeddah - Kingdom of Saudi Arabia'],
            ['address_ar' => 'الدمام - المملكة العربية السعودية', 'address_en' => 'Dammam - Kingdom of Saudi Arabia'],
            ['address_ar' => 'مكة المكرمة - المملكة العربية السعودية', 'address_en' => 'Makkah - Kingdom of Saudi Arabia'],
        ],
    ])->assertSuccessful()
        ->assertJsonCount(3, 'data.settings.addresses');

    expect($setting->fresh()->addresses)->toHaveCount(3);
    $this->assertDatabaseMissing('addresses', ['address_en' => $oldAddressEn]);
});

it('keeps existing addresses when addresses key is omitted on update', function () {
    actingAsSettingAdmin(User::factory()->create());
    $setting = createSettingWithAddresses();

    $this->patchJson('/api/v1/admin/settings', [
        'phone' => '+966512345678',
    ])->assertSuccessful()
        ->assertJsonCount(2, 'data.settings.addresses');

    expect($setting->fresh()->addresses)->toHaveCount(2);
});

it('clears all addresses when an empty array is sent on update', function () {
    actingAsSettingAdmin(User::factory()->create());
    $setting = createSettingWithAddresses();

    $this->patchJson('/api/v1/admin/settings', [
        'addresses' => [],
    ])->assertSuccessful()
        ->assertJsonCount(0, 'data.settings.addresses');

    expect($setting->fresh()->addresses)->toHaveCount(0);
});

it('rejects an address missing the arabic translation', function () {
    actingAsSettingAdmin(User::factory()->create());
    createSettingWithAddresses();

    $this->patchJson('/api/v1/admin/settings', [
        'addresses' => [
            ['address_en' => 'Riyadh - Kingdom of Saudi Arabia'],
        ],
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['addresses.0.address_ar']);
});

it('rejects an address missing the english translation', function () {
    actingAsSettingAdmin(User::factory()->create());
    createSettingWithAddresses();

    $this->patchJson('/api/v1/admin/settings', [
        'addresses' => [
            ['address_ar' => 'الرياض - المملكة العربية السعودية'],
        ],
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['addresses.0.address_en']);
});

it('returns a single localized name and addresses for website settings in arabic', function () {
    $setting = Setting::factory()->create([
        'name_ar' => 'استثماركوم',
        'name_en' => 'Estithmarcom',
    ]);
    $setting->addresses()->createMany([
        ['address_ar' => 'الرياض - المملكة العربية السعودية', 'address_en' => 'Riyadh - Kingdom of Saudi Arabia'],
    ]);

    app()->setLocale('ar');

    $this->getJson('/api/v1/website/settings')
        ->assertSuccessful()
        ->assertJsonPath('data.settings.name', 'استثماركوم')
        ->assertJsonPath('data.settings.addresses.0.address', 'الرياض - المملكة العربية السعودية');
});

it('returns a single localized name and addresses for website settings in english', function () {
    $setting = Setting::factory()->create([
        'name_ar' => 'استثماركوم',
        'name_en' => 'Estithmarcom',
    ]);
    $setting->addresses()->createMany([
        ['address_ar' => 'الرياض - المملكة العربية السعودية', 'address_en' => 'Riyadh - Kingdom of Saudi Arabia'],
    ]);

    app()->setLocale('en');

    $this->getJson('/api/v1/website/settings')
        ->assertSuccessful()
        ->assertJsonPath('data.settings.name', 'Estithmarcom')
        ->assertJsonPath('data.settings.addresses.0.address', 'Riyadh - Kingdom of Saudi Arabia');
});
