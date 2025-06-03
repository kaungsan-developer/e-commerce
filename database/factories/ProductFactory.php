<?php

namespace Database\Factories;

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
        return [
            'name' => fake()->word(),
            'image' => 'example.webp',
            'price' => fake()->numberBetween(10000, 100000),
            'category_id' => fake()->numberBetween(1, 6),
            'stock' => fake()->numberBetween(1, 100),
            'description' => fake()->sentence(),
        ];
    }
}
