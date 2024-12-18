<?php

namespace App\Models;

use App\Enums\AssociateCategories;
use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Associate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'associate_name',
        'address',
        'city',
        'state',
        'phone',
        'website',
        'contract_term',
        'terms_of_association',
        'category',
        'is_active',
        'country_id',
        'branch_id',
        'user_id',
        'associate_reference'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $nextId = DB::table('associates')
                    ->max('id') + 1;

            $model->associate_reference = sprintf('CNLAG%05d', $nextId);
        });
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
        );
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'country_id',
        );
    }

    public static function makeDirectory($folder): string
    {
        $subFolder = 'files/associate/' . $folder;

        Storage::makeDirectory($subFolder);

        return $subFolder;
    }
    protected function contractTerm(): Attribute
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
            'is_active' => 'boolean',
            'country_id' => 'integer',
            'branch_id' => 'integer',
            'user_id' => 'integer',
        ];
    }
}
