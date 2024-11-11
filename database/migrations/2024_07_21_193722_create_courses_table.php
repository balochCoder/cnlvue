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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('level');
            $table->string('campus');
            $table->string('awarding_body')
                ->nullable();
            $table->string('document_1_title')
                ->nullable();
            $table->string('document_1')
                ->nullable();
            $table->string('document_2_title')
                ->nullable();
            $table->string('document_2')
                ->nullable();
            $table->string('document_3_title')
                ->nullable();
            $table->string('document_3')
                ->nullable();
            $table->string('document_4_title')
                ->nullable();
            $table->string('document_4')
                ->nullable();
            $table->string('document_5_title')
                ->nullable();
            $table->string('document_5')
                ->nullable();

            $table->text('part_time_work_details')
                ->nullable();
            $table->text('course_benefits')
                ->nullable();
            $table->text('general_eligibility')
                ->nullable();
            $table->text('language_requirements')
                ->nullable();
            $table->text('additional_information')
                ->nullable();

            $table->enum('quality_of_applicant', ['4', '3', '2', '1'])
                ->nullable();

            $table->json('duration');
            $table->json('course_category')
                ->nullable();
            $table->json('modules')
                ->nullable();
            $table->json('intake')
                ->nullable();

            $table->date('start_date')
                ->nullable();
            $table->date('end_date')
                ->nullable();

            $table->decimal('fee');
            $table->decimal('application_fee')
                ->nullable();
            $table->decimal('monthly_living_cost')
                ->nullable();

            $table->boolean('is_language')
                ->default(false);
            $table->boolean('is_active')->default(true);

            $table->foreignId('currency_id')
                ->constrained('currencies');
            $table->foreignId('representing_institution_id')
                ->constrained('representing_institutions');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
