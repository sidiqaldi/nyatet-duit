<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => random_int(1, 2),
            'category_id' => Category::factory(),
            'amount' => fake()->numerify('##00000'),
            'description' => fake()->sentence(random_int(5, 8)),
            'date' => fake()->date(),
        ];
    }
}
