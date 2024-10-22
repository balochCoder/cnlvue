<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Quotation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'student_nationality',
        'student_passport',
        'student_image',
        'medical_history',
        'permanent_address',
        'correspondence_address',
        'education_history',
        'english_language',
        'work_experience',
        'references',
        'statement_of_purpose',
        'student_gender',
        'student_title',
        'student_marital_status',
        'is_valid_passport',
        'is_accommodation_required',
        'is_medical_required',
        'lead_id',
        'added_by',
        'additional_documents',
        'additional_information',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(
            Lead::class,
            'lead_id',
        );
    }

    public function quotationChoices(): HasMany
    {
        return $this->hasMany(
            QuotationChoice::class,
            'quotation_id',
        );
    }

    public function AddedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by',
        );
    }

    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/quotation/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }

    protected function studentImage(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value == null) {
                    return Storage::url('files/quotations/no_image_available.png');
                }

                return $value;
            },
        );
    }

    protected function casts(): array
    {
        return [
            'permanent_address' => 'array',
            'correspondence_address' => 'array',
            'education_history' => 'array',
            'english_language' => 'array',
            'references' => 'array',
            'work_experience' => 'array',
            'statement_of_purpose' => 'array',
            'additional_documents' => 'array',
            'is_valid_passport' => 'boolean',
            'is_accommodation_required' => 'boolean',
            'is_medical_required' => 'boolean',
            'lead_id' => 'integer',
            'added_by' => 'integer',
        ];
    }
}
