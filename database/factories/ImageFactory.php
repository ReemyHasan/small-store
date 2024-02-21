<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $image = fake()->image('storage/app/public/users',3840,2160, null, false);
        return [
            'url' => 'users/'.$image,
            'imageable_id'=> User::factory(),
            'imageable_type'=> get_class()
        ];
    }
}
