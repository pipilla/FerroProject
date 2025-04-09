<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Rejas',
            'Puertas',
            'Barandas',
            'Estructuras',
            'Escaleras',
            'Tejados',
        ];

        foreach($tags as $name) {
            Tag::create(compact('name'));
        }
    }
}
