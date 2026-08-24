<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => fake()->company(),
            'name_en' => fake()->company(),
            'phone' => '966100000000',
            'email' => fake()->unique()->safeEmail(),
            'facebook' => fake()->url(),
            'x' => fake()->url(),
            'instagram' => fake()->url(),
            'linkedin' => fake()->url(),
            'whatsapp' => fake()->url(),
            'snapchat' => fake()->url(),
            'tiktok' => fake()->url(),
        ];
    }
}
