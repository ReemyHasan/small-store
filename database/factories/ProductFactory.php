<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();
        return [
            'name' => fake()->text('15'),
            'description'=> fake()->slug(),
            'status'=> rand(0,1),
            'quantity'=> rand(0,300),
            'price'=> fake()->randomFloat(1,120,130),
            'vendor_id' => fake()->randomElement($users),
            'category_id' => fake()->randomElement($categories),
        ];
    }
}
