<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message' => fake()->text(),
            'comment_id' => (random_int(0, 2)) ? (Comment::get()->random()->id) : null,
            'post_id' => Post::get()->random()->id,
            'user_id' => User::get()->random()->id,
        ];
    }
}
