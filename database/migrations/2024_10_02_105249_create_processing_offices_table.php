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
        Schema::create('processing_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('time_zone_id')->nullable()->constrained('time_zones');
            $table->string('processing_office_phone')->nullable();
            $table->enum('download_csv', ['Y', 'W', 'N'])->nullable();
            $table->string('contact_person_name');
            $table->string('contact_person_designation');
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_mobile');
            $table->string('contact_person_skype')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_offices');
    }
};
