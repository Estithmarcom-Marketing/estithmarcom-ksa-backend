<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@estithmarcom.com',
            'password' => Hash::make('password'),
        ]);
        $this->call(CountrySeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ContactUsSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(ClientSeeder::class);
    }
}
