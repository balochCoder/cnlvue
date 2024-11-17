<?php

namespace App\Jobs\RepresentingInstitutions;

use App\Models\RepresentingInstitution;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRepresentingInstitution implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array                   $attributes,
        protected RepresentingInstitution $representingInstitution
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
            callback: fn() => $this->representingInstitution->update(
                attributes: $this->attributes
            ),
            attempts: 3
        );
    }
}
