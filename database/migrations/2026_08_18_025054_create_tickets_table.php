<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {

            $table->id();

            // User yang membuat ticket
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Kategori ticket
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            // IT Support yang ditugaskan
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title');

            $table->text('description');

            $table->enum('priority', [
                'low',
                'medium',
                'high'
            ])->default('medium');

            $table->enum('status', [
                'open',
                'processing',
                'resolved',
                'closed'
            ])->default('open');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
