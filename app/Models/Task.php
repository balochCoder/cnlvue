<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'file',
        'description',
        'status',
        'assigned_to',
        'assigned_by',
        'start_date',
        'due_date',
        'application_id'
    ];

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to',
        );
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(
            Application::class,
            'application_id',
        );
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_by',
        );
    }

    public function remarks(): HasMany
    {
        return $this->hasMany(
            TaskRemark::class,
            'task_id',
        );
    }

    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/task/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }
    protected function file(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value == null) {
                    return null;
                }
                return $value;
            },
        );
    }
    protected function casts(): array
    {
        return [
            'assigned_to' => 'integer',
            'assigned_by' => 'integer',
            'start_date' => 'date',
            'due_date' => 'date',
        ];
    }
}
