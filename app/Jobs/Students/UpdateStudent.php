<?php

namespace App\Jobs\Students;

use App\Models\Student;
use App\Models\StudentChoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStudent implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $attributes,
        protected Student $student
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        DatabaseManager $database
    ): void
    {
        $database->transaction(
            callback: function () {
                $this->student->update($this->attributes['storeData']);
                if ($this->attributes['choices']) {
                    $this->student->studentChoices()->delete();
                    foreach ($this->attributes['choices'] as $choice) {
                        StudentChoice::create([
                            'student_id' => $this->student->id,
                            'country_id' => $choice['countryId'],
                            'institution_id' => $choice['institutionId'],
                            'course_id' => $choice['courseId'],
                        ]);
                    }
                }
            },
            attempts: 3
        );
    }
}
