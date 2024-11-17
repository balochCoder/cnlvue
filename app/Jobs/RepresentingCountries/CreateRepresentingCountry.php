<?php

namespace App\Jobs\RepresentingCountries;

use App\Models\RepresentingCountry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\DatabaseManager;


class CreateRepresentingCountry implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $attributes,
        protected array $applicationProcesses
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
            callback: function () {
                $representingCountry = RepresentingCountry::query()->create($this->attributes);

                $filteredProcesses = collect($this->applicationProcesses)
                    ->filter(fn($item) => !is_null($item['name']))
                    ->toArray();

                $representingCountry->applicationProcesses()->createMany($filteredProcesses);
            },
            attempts: 3
        );


    }
}
