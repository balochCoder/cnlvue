<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
        protected $fillable = [
            'application_id',
            'application_process_id',
            'sub_status_id',
            'document',
            'additional_notes'
        ];
}
