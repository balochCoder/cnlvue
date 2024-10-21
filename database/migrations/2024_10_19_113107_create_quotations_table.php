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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();


            $table->string('student_nationality');
            $table->string('student_passport')->nullable();
            $table->string('student_image')->nullable();

            $table->text('medical_history')->nullable();
            $table->text('additional_information')->nullable();

            $table->json('permanent_address')->nullable();
            $table->json('correspondence_address')->nullable();
            $table->json('education_history')->nullable();
            $table->json('english_language')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('references')->nullable();
            $table->json('statement_of_purpose')->nullable();
            $table->json('additional_documents')->nullable();

            $table->enum('student_gender', ['Male', 'Female'])->nullable();
            $table->enum('student_title', ['Mr', 'Mrs', 'Ms', 'Miss'])->nullable();
            $table->enum('student_marital_status', ['Single', 'Married'])->nullable();

            $table->boolean('is_valid_passport')->default(false);
            $table->boolean('is_accommodation_required')->default(false);
            $table->boolean('is_medical_required')->default(false);

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();
            $table->foreignId('added_by')
                ->constrained('users')
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
        Schema::dropIfExists('quotations');
    }
};
