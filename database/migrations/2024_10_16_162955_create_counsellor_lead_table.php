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
        Schema::create('counsellor_lead', function (Blueprint $table) {
            $table->foreignId('counsellor_id')
                ->constrained('counsellors');
            $table->foreignId('lead_id')
                ->constrained('leads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellor_lead');
    }
};
