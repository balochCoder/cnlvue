<?php

namespace App\Models;

use App\Enums\CourseLevel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'representing_institution_id',
        'title',
        'level',
        'duration',
        'start_date',
        'end_date',
        'campus',
        'awarding_body',
        'fee',
        'application_fee',
        'currency_id',
        'monthly_living_cost',
        'part_time_work_details',
        'course_benefits',
        'general_eligibility',
        'quality_of_applicant',
        'is_language',
        'language_requirements',
        'additional_information',
        'course_category',
        'document_1_title',
        'document_1',
        'document_2_title',
        'document_2',
        'document_3_title',
        'document_3',
        'document_4_title',
        'document_4',
        'document_5_title',
        'document_5',
        'modules',
        'intake',
        'is_active'
    ];


    protected function casts(): array
    {
        return [
            'level' => CourseLevel::class,
            'duration' => 'array',
            'course_category' => 'array',
            'modules' => 'array',
            'intake' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'fee' => 'float',
            'application_fee' => 'float',
            'currency_id' => 'integer',
            'representing_institution_id' => 'integer',
            'is_active' => 'boolean'
        ];
    }

    public function representingInstitution(): BelongsTo
    {
        return $this->belongsTo(RepresentingInstitution::class, 'representing_institution_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/courses/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }
    protected function document1(): Attribute
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

    protected function document2(): Attribute
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

    protected function document3(): Attribute
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

    protected function document4(): Attribute
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

    protected function document5(): Attribute
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
}
