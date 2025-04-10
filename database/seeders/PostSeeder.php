<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory(30)->create();
        $media = Media::all()->pluck('id')->toArray();
        $tags = Tag::all()->pluck('id')->toArray();
        foreach($posts as $post){
            $post->media()->attach($this->getArrayRandomId($media));
            $post->tags()->attach($this->getArrayRandomId($tags));
        }
    }

    public function getArrayRandomId(array $array): array
    {
        return array_slice($array, 0, random_int(1, count($array) - 1));
    }
}
