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
        Schema::create('associates', function (Blueprint $table) {
            $table->id();

            $table->string('associate_name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('contract_term')->nullable();

            $table->longText('terms_of_association')->nullable();

            $table->enum('category', ['silver', 'gold', 'platnium']);

            $table->boolean('is_active')->default(true);

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
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
        Schema::dropIfExists('associates');
    }
};
