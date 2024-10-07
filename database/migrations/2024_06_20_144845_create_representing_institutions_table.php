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
        Schema::create('representing_institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('representing_country_id')
                ->constrained('representing_countries')
                ->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['direct', 'indirect'])->nullable();
            $table->string('campus')->nullable();
            $table->string('website');
            $table->decimal('monthly_living_cost')->nullable();
            $table->decimal('funds_required')->nullable();
            $table->decimal('application_fee')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->unsignedInteger('contract_term')->nullable();
            $table->enum('quality_of_applicant',['excellent','good','average','below average'])->nullable();
            $table->string('contract_copy')->nullable();
            $table->dateTime('contract_expiry')->nullable();
            $table->boolean('is_language')->default(false);
            $table->text('language_requirements')->nullable();
            $table->text('institutional_benefits')->nullable();
            $table->text('part_time_work_details')->nullable();
            $table->text('scholarships_policy')->nullable();
            $table->text('institution_status_notes')->nullable();
            $table->string('logo')->nullable();
            $table->string('prospectus')->nullable();
            $table->string('document_1_title')->nullable();
            $table->string('document_1')->nullable();
            $table->string('document_2_title')->nullable();
            $table->string('document_2')->nullable();
            $table->string('contact_person_name');
            $table->string('contact_person_email');
            $table->string('contact_person_phone');
            $table->string('contact_person_designation');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representing_institutions');
    }
};
