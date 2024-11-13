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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('student_first_name');
            $table->string('student_last_name')
                ->nullable();
            $table->string('intake_of_interest_month')
                ->nullable();
            $table->string('intake_of_interest_year')
                ->nullable();
            $table->string('student_email')->nullable();
            $table->string('student_phone')->nullable();
            $table->string('student_emergency_phone')->nullable();
            $table->string('student_mobile')->nullable();
            $table->string('student_skype')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->string('course_level_of_interest')->nullable();
            $table->string('institution_name')->nullable();

            $table->text('additional_info')->nullable();

            $table->enum('status', [
                'new',
                'cold',
                'completed',
                'failed',
                'future_lead',
                'hot',
                'medium',
                'not_responding'
            ])->default('new');

            $table->json('course_category')->nullable();

            $table->date('date_of_birth')
                ->nullable();

            $table->boolean('is_country_preferred')
                ->default(false);
            $table->boolean('is_application_generated')
                ->default(false);

            $table->foreignId('lead_source_id')
                ->constrained('lead_sources')
                ->cascadeOnDelete();
            $table->foreignId('interested_country_id')
                ->nullable()
                ->constrained('countries')
                ->cascadeOnDelete();
            $table->foreignId('interested_institution_id')
                ->nullable()
                ->constrained('representing_institutions')
                ->cascadeOnDelete();
            $table->foreignId('added_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('branch_id')
                ->constrained('branches')
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
        Schema::dropIfExists('leads');
    }
};
