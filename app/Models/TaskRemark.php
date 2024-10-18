<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskRemark extends Model
{
    use HasFactory;

    protected $fillable = [
        'remark',
        'task_id',
        'created_by',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(
            Task::class,
            'task_id',
        );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
        );
    }
    protected function casts(): array
    {
        return [
            'task_id' => 'integer',
            'created_by' => 'integer',
        ];
    }
}
