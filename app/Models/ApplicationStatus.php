<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatus extends Model
{
        protected $fillable = [
            'application_id',
            'application_process_id',
            'sub_status_id',
            'document',
            'additional_notes'
        ];

    public function applicationProcess(): BelongsTo
    {
        return $this->belongsTo(
            ApplicationProcess::class,
            'application_process_id',
        );
    }

    public function subStatus(): BelongsTo
    {
        return $this->belongsTo(
            SubStatus::class,
            'sub_status_id',
        )->whereNotNull('sub_status_id');
    }
}
