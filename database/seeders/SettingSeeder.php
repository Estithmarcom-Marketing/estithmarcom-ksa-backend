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
            'address' => 'الرياض - المملكة العربية السعودية',
            'facebook' => 'https://estthimarcom.net',
            'instagram' => 'https://estthimarcom.net/',
            'linkedin' => 'https://estthimarcom.net/',
            'whatsapp' => 'https://estthimarcom.net/',
            'snapchat' => 'https://estthimarcom.net/',
            'tiktok' => 'https://estthimarcom.net/',
            'x' => 'https://estthimarcom.net/',
        ];

        Setting::create($setting);
    }
}
