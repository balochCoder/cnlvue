<?php

namespace App\Models;

use App\Enums\DownloadCSV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Counsellor extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'phone',
        'mobile',
        'whatsapp',
        'download_csv',
        'is_processing_officer',
        'user_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_processing_officer' => 'boolean',
            'user_id' => 'integer',
            'branch_id' => 'integer',
            'download_csv' => DownloadCSV::class
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(RepresentingInstitution::class, foreignPivotKey: 'counsellor_id', relatedPivotKey: 'institution_id')
            ->using(CounsellorRepresentingInstitution::class);
    }
}
