<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
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
        $image = fake()->image('storage/app/public/products',400,300, null, false);
        return [
            'url' => 'products/'.$image,
            'imageable_id'=> Product::factory(),
            'imageable_type'=> 'App\Models\Product'
        ];
    }
}
