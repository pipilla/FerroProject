<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from' => fake()->name(),
            'to' => fake()->name(),
            'date' => fake()->date(),
            'details' => (random_int(0,3)) ? fake()->text() : "",
        ];
    }
}
