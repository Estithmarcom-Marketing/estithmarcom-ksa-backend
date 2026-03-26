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
                'alt' => 'ramky',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/ramky.png'),
            ],
            [
                'alt' => 'alrawha',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/alrawha.png'),
            ],
            [
                'alt' => 'itfaq',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/itfaq.png'),
            ],
            [
                'alt' => 'eshhar',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/eshhar.png'),
            ],
            [
                'alt' => 'ryan',
                'active' => true,
                'link' => 'https://estthimarcom.net/',
                'image' => public_path('seedersImages/Client/ryan.png'),
            ],
        ];
        foreach ($clients as $data) {

            $client = Client::create([
                'alt' => $data['alt'],
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
