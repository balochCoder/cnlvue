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
        Schema::create('representing_countries', function (Blueprint $table) {
            $table->id();

            $table->string('monthly_living_cost')
                ->nullable();

            $table->text('visa_requirements')
                ->nullable();
            $table->text('part_time_work_details')
                ->nullable();
            $table->text('country_benefits')
                ->nullable();

            $table->boolean('is_active')
                ->default(false);

            $table->foreignId('country_id')
                ->unique()
                ->constrained('countries')
                ->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representing_countries');
    }
};
