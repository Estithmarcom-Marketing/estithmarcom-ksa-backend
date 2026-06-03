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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@estithmarcom.com',
            'password' => Hash::make('password'),
        ]);
        $this->call([
            CategorySeeder::class,
            CountrySeeder::class,
            FaqSeeder::class,
            SettingSeeder::class,
            ContactUsSeeder::class,
            BlogSeeder::class,
            ClientSeeder::class,
            ServiceSeeder::class,
            RequestServiceSeeder::class,
            FreeZoneSeeder::class,
            ResidencySeeder::class,
            HighlightSeeder::class,
        ]);
    }
}
