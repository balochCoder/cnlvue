<?php

namespace App\Jobs\Leads;

use App\Models\Lead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateLead implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $attributes,
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
                $lead = Lead::create($this->attributes['storeData']);
                $lead->counsellors()->sync($this->attributes['counsellorId']);

                if ($this->attributes['leadType'])
                {
                    $lead->followups()->create([
                        'lead_type' => $this->attributes['leadType'],
                        'follow_up_date' => $this->attributes['followUpDate'],
                        'follow_up_mode' => $this->attributes['followUpMode'],
                        'time' => json_encode($this->attributes['time']),
                        'remarks' => $this->attributes['remarks'],
                        'added_by' => $this->attributes['addedBy'],
                    ]);
                }
            },
            attempts: 3
        );
    }
}
