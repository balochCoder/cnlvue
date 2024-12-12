<?php

namespace App\Jobs\Applications;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateApplication implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $attributes
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
                $application = Application::create($this->attributes);
                $course = Course::find($this->attributes['course_id']);
                $status = $course->representingInstitution->representingCountry->applicationProcesses()->first();
               ApplicationStatus::query()->create(
                   [
                       'application_id' => $application->id,
                       'application_process_id' => $status->id,
                   ]
               );
            },
            attempts: 3
        );
    }
}
