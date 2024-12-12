<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'student_reference',
        'student_first_name',
        'student_last_name',
        'student_email',
        'student_phone',
        'student_mobile',
        'student_skype',
        'student_nationality',
        'application_process_id',
        'student_passport',
        'student_image',
        'intake_month',
        'intake_year',
        'application_payment_method',
        'application_payment_reference',
        'scholarship_offered',
        'scholarship_proof',
        'fee_payment_method',
        'fee_payment_reference',
        'date_of_birth',
        'application_payment_date',
        'fee_payment_date',
        'medical_history',
        'additional_information',
        'application_fee',
        'total_tuition_fee_to_be_paid',
        'fee_paid_so_far',
        'first_year_fee_due',
        'total_fee_due',
        'permanent_address',
        'correspondence_address',
        'education_history',
        'english_language',
        'work_experience',
        'references',
        'statement_of_purpose',
        'additional_documents',
        'student_gender',
        'student_title',
        'student_marital_status',
        'is_valid_passport',
        'is_accommodation_required',
        'is_medical_required',
        'student_id',
        'course_id',
        'currency_id',
        'lead_source_id',
        'added_by',
        'application_remarks',
        'passport_issue_date',
        'passport_expiry_date',
        'counsellor_id',
        'associate_id'
    ];

    public function counsellor(): BelongsTo
    {
        return $this->belongsTo(
            Counsellor::class,
            'counsellor_id',
        );
    }

    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/application/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }

    public function associate(): BelongsTo
    {
        return $this->belongsTo(
            Associate::class,
            'associate_id',
        );
    }

    public function applicationStatuses(): HasMany
    {
        return $this->hasMany(
            ApplicationStatus::class,
            'application_id',
        );
    }
//    protected function studentImage(): Attribute
//    {
//        return Attribute::make(
//            get: function ($value) {
//                if ($value == null) {
//                    return Storage::url('files/application/no_image_available.png');
//                }
//
//                return $value;
//            },
//        );
//    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by',
        );
    }

    public function followups(): MorphMany
    {
        return $this->morphMany(
            Followup::class,
            'followupable',
        );
    }

    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(
            LeadSource::class,
            'lead_source_id',
        );
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(
            Currency::class,
            'currency_id',
        );
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(
            Course::class,
            'course_id',
        );
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
        );
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $nextId = DB::table('applications')
                    ->max('id') + 1;

            $model->student_reference = sprintf('CNL%07d', $nextId);
        });
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
            'student_id' => 'integer',
            'associate_id' => 'integer',
            'counsellor_id' => 'integer',
            'added_by' => 'integer',
            'date_of_birth' => 'date',
            'course_id' => 'integer',
            'currency_id' => 'integer',
            'lead_source_id' => 'integer',
            'application_fee' => 'float',
            'total_tuition_fee_to_be_paid' => 'float',
            'fee_paid_so_far' => 'float',
            'first_year_fee_due' => 'float',
            'total_fee_due' => 'float',
            'passport_issue_date' => 'date',
            'passport_expiry_date' => 'date',
            'application_payment_date' => 'date',
            'fee_payment_date' => 'date',
        ];
    }
}
