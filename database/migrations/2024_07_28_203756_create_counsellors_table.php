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
        Schema::create('counsellors', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_processing_officer')
                ->default(false);
            $table->boolean('is_active')->default(true);

            $table->foreignId('branch_id')
                ->constrained('branches');
            $table->foreignId('user_id')
                ->constrained('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellors');
    }
};
