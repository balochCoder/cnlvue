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
            $table->string('phone')->nullable();


            $table->boolean('is_active')->default(true);

            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('time_zone_id')->nullable()->constrained('time_zones');
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
