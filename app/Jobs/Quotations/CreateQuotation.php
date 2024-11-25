<?php

namespace App\Jobs\Quotations;

use App\Models\Lead;
use App\Models\Quotation;
use App\Models\QuotationChoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateQuotation implements ShouldQueue
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
    public function handle(
        DatabaseManager $database
    ): void
    {
        $database->transaction(
            callback: function ()  {
                $quotation = Quotation::create($this->attributes['storeData']);
                if ($this->attributes['choices']) {
                    foreach ($this->attributes['choices'] as $choice) {
                        QuotationChoice::create([
                            'quotation_id' => $quotation->id,
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
