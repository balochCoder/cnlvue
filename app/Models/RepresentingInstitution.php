<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class RepresentingInstitution extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'representing_country_id',
        'name',
        'type',
        'campus',
        'website',
        'monthly_living_cost',
        'funds_required',
        'application_fee',
        'currency_id',
        'contract_term',
        'quality_of_applicant',
        'contract_copy',
        'contract_expiry',
        'is_language',
        'language_requirements',
        'institutional_benefits',
        'part_time_work_details',
        'scholarships_policy',
        'institution_status_notes',
        'logo',
        'prospectus',
        'document_1_title',
        'document_1',
        'document_2_title',
        'document_2',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'contact_person_designation',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'representing_country_id' => 'integer',
            'currency_id' => 'integer',
            'contract_expiry' => 'datetime',
            'is_active' => 'boolean',
            'is_language' => 'boolean',
            'application_fee' => 'float',
            'funds_required' => 'float',
            'monthly_living_cost' => 'float',
        ];
    }

    public function representingCountry(): BelongsTo
    {
        return $this->belongsTo(RepresentingCountry::class, 'representing_country_id')
            ->with('country');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'representing_institution_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/representingInstitutions/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }

    protected function logo(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value == null) {
                    return Storage::url('files/representingInstitutions/no_image_available.png');
                }

                return $value;
            },
        );
    }

    protected function contractCopy(): Attribute
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

    protected function prospectus(): Attribute
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

    public function counsellors(): BelongsToMany
    {
        return $this->belongsToMany(Counsellor::class, foreignPivotKey: 'institution_id', relatedPivotKey: 'counsellor_id')
            ->using(CounsellorRepresentingInstitution::class);
    }
}
