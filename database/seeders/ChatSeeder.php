<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $chats = Chat::factory(30)->create();

        foreach ($chats as $chat) {
            $user1 = $users->random();

            if (!$chat->is_group) {
                // Chats privados entre 2 usuarios
                $chat->users()->attach($user1->id);

                $user2 = $users->where('id', '!=', $user1->id)->random();
                $chat->users()->attach($user2->id);

                for ($i = 0; $i < random_int(1, 9); $i++) {
                    Message::create([
                        'sender_id' => rand(0, 1) ? $user1->id : $user2->id,
                        'chat_id' => $chat->id,
                        'content' => fake()->sentence(7),
                    ]);
                }
            } else {
                // Grupos con más de 2 usuarios
                $chat->users()->attach($user1->id);

                $other_users = $users->where('id', '!=', $user1->id)->shuffle()->take(random_int(2, 6));
                $chat->users()->attach($other_users->pluck('id'));

                $participants = $other_users->push($user1);

                for ($i = 0; $i < random_int(5, 20); $i++) {
                    $sender = $participants->random();
                    Message::create([
                        'sender_id' => $sender->id,
                        'chat_id' => $chat->id,
                        'content' => fake()->sentence(7),
                    ]);
                }
            }
        }
    }
}
