<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = [
            'name_ar' => 'استثماركوم',
            'name_en' => 'Estithmarcom',
            'phone' => '966100000000',
            'email' => 'info@estithmarcom.com',
            'facebook' => 'https://estthimarcom.net',
            'instagram' => 'https://estthimarcom.net/',
            'linkedin' => 'https://estthimarcom.net/',
            'whatsapp' => 'https://estthimarcom.net/',
            'snapchat' => 'https://estthimarcom.net/',
            'tiktok' => 'https://estthimarcom.net/',
            'x' => 'https://estthimarcom.net/',
        ];

        $setting = Setting::create($setting);

        $setting->addresses()->createMany([
            [
                'address_ar' => 'الرياض - المملكة العربية السعودية',
                'address_en' => 'Riyadh - Kingdom of Saudi Arabia',
            ],
        ]);
    }
}
