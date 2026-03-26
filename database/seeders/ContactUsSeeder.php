<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactUs = [
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmedhassan@example.com',
                'phone' => '+201012345678',
                'message' => 'I would like to know more about your services and pricing plans.',
                'contacted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmed Mohamed',
                'email' => 'ahmedmohamed@example.com',
                'phone' => '+201098765432',
                'message' => 'Please contact me regarding technical support for my account.',
                'contacted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Omar Ali',
                'email' => 'omarali@example.com',
                'phone' => '+201112223334',
                'message' => 'I want to request a demo for your platform.',
                'contacted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('contact_us')->insert($contactUs);

    }
}
