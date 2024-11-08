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
            'representing_country_id' => $this->faker->randomElement($countries),
            'name' => $this->faker->words(3, true),
            'type' => $this->faker->randomElement(InstituteType::cases()),
            'campus'=> $this->faker->city(),
            'website' => $this->faker->url(),
            'monthly_living_cost'=> $this->faker->randomFloat(2, 10, 100),
            'funds_required'=> $this->faker->randomFloat(2, 10, 100),
            'application_fee'=> $this->faker->randomFloat(2, 10, 100),
            'currency_id'=> $currency->id,
            'contract_term' => 2,
            'quality_of_applicant' => $this->faker->randomElement(ApplicantDesired::cases()),
            'contact_person_name' => $this->faker->name(),
            'contact_person_email'=> $this->faker->email(),
            'contact_person_phone'=> $this->faker->phoneNumber(),
            'contact_person_designation'=> $this->faker->jobTitle(),
            'contract_expiry'=> $this->faker->dateTimeThisYear(),
            'part_time_work_details' => $this->faker->paragraph(),
            'logo' => $this->faker->imageUrl(),
        ];
    }
}
