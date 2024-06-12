<?php

namespace Database\Factories;

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
            'payer' => User::inRandomOrder()->first()->id,
            'payee' => User::inRandomOrder()->first()->id,
            'value' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
