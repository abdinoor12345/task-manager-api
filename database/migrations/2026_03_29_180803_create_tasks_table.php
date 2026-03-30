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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Task title [cite: 18-20]
        $table->date('due_date'); // Deadline [cite: 21-23]
        $table->enum('priority', ['low', 'medium', 'high']); // [cite: 24-26]
        $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
            $table->timestamps();
            $table->unique(['title', 'due_date']); // Ensure unique title and due date combination [cite: 27-29]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
