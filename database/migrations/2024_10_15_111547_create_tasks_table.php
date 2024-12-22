<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('file')->nullable();

            $table->text('description');

            $table->enum('status', ['new', 'completed', 'in_process'])->default('new');

            $table->foreignId('assigned_to')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('assigned_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('start_date');
            $table->timestamp('due_date');

            $table->foreignId('application_id')
                ->nullable()
                ->constrained('applications')
                ->cascadeOnDelete();

            $table->timestamps();
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
