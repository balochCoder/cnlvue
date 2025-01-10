<?php

namespace App\Jobs\Applications;

use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateApplication implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $attributes,
        protected Application $application
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn() => $this->application->update($this->attributes),
            attempts: 3
        );
    }
}
