<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2025_04_30_100732_create_messages_table.php
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDeleteonDelete();
            $table->foreignId('chat_id')->constrained()->cascadeOnDeleteonDelete();
=======
>>>>>>> f2aff96 (Cambios para que funcione react):database/migrations/2025_03_20_112158_create_messages_table.php
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
