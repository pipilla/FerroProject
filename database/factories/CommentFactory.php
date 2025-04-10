<?php

namespace Database\Factories;

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
        $post = Post::get()->random();
        $commentPost = (random_int(0, 2)) ? (($post->comments()->count()) ? $post->comments()->get()->random()->id : null) : null;
        return [
            'message' => fake()->text(),
            'comment_id' => $commentPost,
            'post_id' => $post->id,
            'user_id' => User::get()->random()->id,
        ];
    }
}
