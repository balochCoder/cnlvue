<?php

namespace Database\Factories;

use App\Enums\ApplicantDesired;
use App\Enums\InstituteType;
use App\Models\Currency;
use App\Models\RepresentingCountry;
use App\Models\RepresentingInstitution;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class RepresentingInstitutionFactory extends Factory
{
    protected $model = RepresentingInstitution::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = RepresentingCountry::all()->pluck('id')->toArray();
        $currency = Currency::query()->where('id', 49)->firstOrFail();
        return [
            'representing_country_id' => fake()->randomElement($countries),
            'name' => fake()->words(3, true),
            'type' => fake()->randomElement(InstituteType::cases()),
            'campus'=> fake()->city(),
            'website' => fake()->url(),
            'monthly_living_cost'=> fake()->randomFloat(2, 10, 100),
            'funds_required'=> fake()->randomFloat(2, 10, 100),
            'application_fee'=> fake()->randomFloat(2, 10, 100),
            'currency_id'=> $currency->id,
            'contract_term' => 2,
            'quality_of_applicant' => fake()->randomElement(ApplicantDesired::cases()),
            'contact_person_name' => fake()->name(),
            'contact_person_email'=> fake()->email(),
            'contact_person_phone'=> fake()->phoneNumber(),
            'contact_person_designation'=> fake()->jobTitle(),
            'contract_expiry'=> Carbon::now()->addYears(2),
            'part_time_work_details' => fake()->paragraph(),
            'logo' => fake()->imageUrl(),
        ];
    }
}
