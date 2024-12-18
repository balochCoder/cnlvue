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
        Schema::create('application_processes', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->text('notes')->nullable();

            $table->integer('order')->default(0);

            $table->boolean('is_active')->default(false);

            $table->foreignId('representing_country_id')
                ->constrained('representing_countries')
                ->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_processes');
    }
};
