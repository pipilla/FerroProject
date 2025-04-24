<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concept>
 */
class ConceptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(4),
            'price' => fake()->randomFloat(2, 0.25, 100000),
            'quantity' => fake()->randomNumber(3),
            'tax_id' => Tax::all()->random()->id,
            'invoice_id' => Invoice::all()->random()->id,
        ];
    }
}
