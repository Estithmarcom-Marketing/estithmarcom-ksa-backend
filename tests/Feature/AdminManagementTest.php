<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function actingAsAdmin(User $user): User
{
    Sanctum::actingAs($user);
    auth('api')->setUser($user);

    return $user;
}

it('stores an admin with a normalized phone', function () {
    $admin = actingAsAdmin(User::factory()->create());

    $this->postJson('/api/v1/admin/admins', [
        'name' => 'New Admin',
        'email' => 'new-admin@gmail.com',
        'phone' => '+966 51 234 5678',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertCreated()
        ->assertJsonPath('data.admin.phone', '966512345678');

    $this->assertDatabaseHas('users', [
        'email' => 'new-admin@gmail.com',
        'phone' => '966512345678',
    ]);
});

it('stores an admin without a phone', function () {
    $admin = actingAsAdmin(User::factory()->create());

    $this->postJson('/api/v1/admin/admins', [
        'name' => 'New Admin',
        'email' => 'no-phone-admin@gmail.com',
        'phone' => null,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertCreated();

    $this->assertDatabaseHas('users', [
        'email' => 'no-phone-admin@gmail.com',
        'phone' => null,
    ]);
});

it('rejects an invalid phone when storing an admin', function () {
    $admin = actingAsAdmin(User::factory()->create());

    $this->postJson('/api/v1/admin/admins', [
        'name' => 'New Admin',
        'email' => 'invalid-phone-admin@gmail.com',
        'phone' => 'not-a-phone',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('phone');
});

it('updates an admin phone as the super admin', function () {
    $superAdmin = actingAsAdmin(User::factory()->create(['id' => 1]));
    $admin = User::factory()->create();

    $this->patchJson("/api/v1/admin/admins/{$admin->id}", [
        'phone' => '+966 55 987 6543',
    ])->assertOk()
        ->assertJsonPath('data.admin.phone', '966559876543');

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'phone' => '966559876543',
    ]);
});

it('updates the authenticated admin profile phone', function () {
    $admin = actingAsAdmin(User::factory()->create());

    $this->patchJson('/api/v1/admin/admins', [
        'phone' => '+966 53 111 2222',
    ])->assertOk()
        ->assertJsonPath('data.admin.phone', '966531112222');

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'phone' => '966531112222',
    ]);
});

it('clears the admin phone when a null phone is provided', function () {
    $superAdmin = actingAsAdmin(User::factory()->create(['id' => 1]));
    $admin = User::factory()->create(['phone' => '966512345678']);

    $this->patchJson("/api/v1/admin/admins/{$admin->id}", [
        'phone' => null,
    ])->assertOk()
        ->assertJsonPath('data.admin.phone', null);

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'phone' => null,
    ]);
});
