<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ApplicationStatus extends Model
{
        protected $fillable = [
            'application_id',
            'application_process_id',
            'sub_status_id',
            'document',
            'additional_notes',
            'user_id',
            'is_task'
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
        );
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
        );
    }

    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/applicationStatuses/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }
}
