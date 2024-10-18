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
        Schema::create('followups', function (Blueprint $table) {
            $table->id();

            $table->text('remarks');

            $table->enum('lead_type', [
                'cold',
                'completed',
                'failed',
                'future_lead',
                'hot',
                'medium',
                'not_responding'
            ]);

            $table->enum('follow_up_mode', [
                'bbm',
                'zoom',
                'email',
                'google_meet',
                'meeting',
                'phone',
                'skype',
                'whatsapp',
            ]);

            $table->date('follow_up_date');

            $table->json('time');


            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            $table->foreignId('added_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followups');
    }
};
