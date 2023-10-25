<?php

namespace Database\Factories;

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
            'account_from_id' => str()->uuid(),
            'account_to_id' => str()->uuid(),
            'value' => rand(100, 999),
            'kind' => 'id',
            'key' => str()->uuid(),
            'description' => $this->faker->sentence(5),
            'status' => 'pending',
        ];
    }
}
