<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isGroup = !random_int(0,4);
        return [
            'name' => ($isGroup) ? fake()->sentence(3) : null,
            'is_group' => $isGroup,
        ];
    }
}
