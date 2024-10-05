<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }
    public function representingCountry() : HasOne
    {
        return $this->hasOne(RepresentingCountry::class, 'country_id');
    }
}
