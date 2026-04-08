<?php

namespace Database\Seeders;

use App\Enum\RequestServiceStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            [
                'name' => 'Ahmed Mohamed',
                'email' => 'ahmed@example.com',
                'phone' => '+201001112233',
                'service_id' => 1,
                'country_id' => 1,
                'status' => RequestServiceStatusEnum::PENDING,
                'additional_info' => json_encode([
                    'company_name' => 'Future Tech',
                    'budget' => '50000 USD',
                    'notes' => 'Need fast setup'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sara Ali',
                'email' => 'sara@example.com',
                'phone' => '+966501234567',
                'service_id' => 2,
                'country_id' => 2,
                'status' => RequestServiceStatusEnum::PENDING,
                'additional_info' => json_encode([
                    'service_type' => 'Administrative Support',
                    'duration' => '6 months'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Omar Khaled',
                'email' => 'omar@example.com',
                'phone' => '+971501112233',
                'service_id' => 3,
                'country_id' => 3,
                'status' => RequestServiceStatusEnum::CANCELED,
                'additional_info' => json_encode([
                    'project' => 'Marketing Strategy',
                    'industry' => 'Real Estate'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohamed Hassan',
                'email' => 'mohamed@example.com',
                'phone' => '+97455112233',
                'service_id' => 4,
                'country_id' => 4,
                'status' => RequestServiceStatusEnum::PENDING,
                'additional_info' => json_encode([
                    'license_type' => 'Commercial License'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fatma Mahmoud',
                'email' => 'fatma@example.com',
                'phone' => '+96555112233',
                'service_id' => 5,
                'country_id' => 5,
                'status' => RequestServiceStatusEnum::CONTACTED,
                'additional_info' => json_encode([
                    'workspace_type' => 'Private Office'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Khaled Ibrahim',
                'email' => 'khaled@example.com',
                'phone' => '+212651234567',
                'service_id' => 6,
                'country_id' => 6,
                'status' => RequestServiceStatusEnum::FORWARDED,
                'additional_info' => json_encode([
                    'project_type' => 'Startup',
                    'investment' => '100000 USD'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('request_services')->insert($requests);
    }
}
