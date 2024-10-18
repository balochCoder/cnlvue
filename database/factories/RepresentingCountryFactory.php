<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\RepresentingCountry;
use Illuminate\Database\Eloquent\Factories\Factory;


class RepresentingCountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RepresentingCountry::class;
    public function definition(): array
    {
        $countries = Country::all()->pluck('id')->toArray();
        return [
            'country_id' => $this->faker->unique()->randomElement($countries),
            'monthly_living_cost' => $this->faker->numberBetween(1000, 10000),
            'visa_requirements'=> $this->faker->sentence(),
            'part_time_work_details'=>$this->faker->sentence(),
            'country_benefits'=>$this->faker->sentence(),
        ];
    }
}
