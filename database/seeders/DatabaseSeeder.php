<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Concept;
use App\Models\Invoice;
use App\Models\Media;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('media');
        Storage::makeDirectory('media');

        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 3,

        ]);

        User::factory(20)->create();
<<<<<<< HEAD
        Media::factory(40)->create();
=======
        Media::factory(30)->create();
>>>>>>> 2878e5a99859a06bc44cd10037dfaea5568a6f59
        $this->call(PostSeeder::class);
        Comment::factory(50)->create();
        Task::factory(50)->create();
        
        Invoice::factory(5)->create();
        $this->call(TaxSeeder::class);
        Concept::factory(70)->create();

        $this->call(ChatSeeder::class);
    }
}
