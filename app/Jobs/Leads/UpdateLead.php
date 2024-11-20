<?php

namespace App\Jobs\Leads;

use App\Models\Lead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLead implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $attributes,
        protected Lead $lead
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
                $this->lead->update($this->attributes['updateData']);

                if ($this->attributes['leadType'])
                {
                    $this->lead->followups()->create([
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
