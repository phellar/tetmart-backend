<?php

namespace Database\Factories;

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

     protected $model = \App\Models\Product::class;

    public function definition(): array
    {
            return [
                // assign product to a random user (vendor)
                'user_id' => User::inRandomOrder()->first()->id,
                'product_name' => $this->faker->word(),
                'description' => $this->faker->sentence(),
                'price' => $this->faker->randomFloat(2, 100, 5000),
                // 'stock' => $this->faker->numberBetween(5, 100),
            ];
    }
}
