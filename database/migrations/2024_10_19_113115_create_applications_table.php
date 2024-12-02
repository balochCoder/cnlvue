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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->string('student_reference')->unique();
            $table->string('student_first_name');
            $table->string('student_last_name')->nullable();
            $table->string('student_email')->nullable();
            $table->string('student_phone')->nullable();
            $table->string('student_mobile')->nullable();
            $table->string('student_skype')->nullable();

            $table->string('student_nationality');
            $table->string('student_passport')->nullable();
            $table->string('student_image')->nullable();
            $table->string('intake_month')->nullable();
            $table->string('intake_year')->nullable();

            $table->string('application_payment_method')->nullable();
            $table->string('application_payment_reference')->nullable();
            $table->string('scholarship_offered')->nullable();
            $table->string('scholarship_proof')->nullable();
            $table->string('fee_payment_method')->nullable();
            $table->string('fee_payment_reference')->nullable();

            $table->date('date_of_birth');
            $table->date('application_payment_date')->nullable();
            $table->date('fee_payment_date')->nullable();


            $table->text('medical_history')->nullable();
            $table->text('additional_information')->nullable();

            $table->decimal('application_fee')->nullable();
            $table->decimal('total_tuition_fee_to_be_paid')->nullable();
            $table->decimal('fee_paid_so_far')->nullable();
            $table->decimal('first_year_fee_due')->nullable();
            $table->decimal('total_fee_due')->nullable();

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
            $table->boolean('is_ielts')->default(false);
            $table->boolean('is_toefl')->default(false);
            $table->boolean('is_pte')->default(false);
            $table->boolean('is_gmat')->default(false);


            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->foreignId('currency_id')
                ->nullable()
                ->constrained('currencies')
                ->cascadeOnDelete();

            $table->foreignId('lead_source_id')
                ->nullable()
                ->constrained('lead_sources')
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
        Schema::dropIfExists('applications');
    }
};
