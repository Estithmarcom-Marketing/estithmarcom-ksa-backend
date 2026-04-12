<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'alt_en' => 'ramky',
                'alt_ar' => 'رامكي',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/ramky.png'),
            ],
            [
                'alt_en' => 'alrawha',
                'alt_ar' => 'الراوحة',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/alrawha.png'),
            ],
            [
                'alt_en' => 'itfaq',
                'alt_ar' => 'اتفاق',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/itfaq.png'),
            ],
            [
                'alt_en' => 'eshhar',
                'alt_ar' => 'اشهار',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/eshhar.png'),
            ],
            [
                'alt_en' => 'ryan',
                'alt_ar' => 'ريان',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/ryan.png'),
            ],
        ];
        foreach ($clients as $data) {

            $client = Client::create([
                'alt_ar' => $data['alt_ar'],
                'alt_en' => $data['alt_en'],
                'active' => $data['active'],
                'link' => $data['link'],
            ]);

            if (File::exists($data['image'])) {
                $client
                    ->copyMedia($data['image'])
                    ->toMediaCollection('client');
            }
        }
    }
}
