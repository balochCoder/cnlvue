<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\ProcessingOffice;
use App\Models\TimeZone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProcessingOfficeFactory extends Factory
{
    protected $model = ProcessingOffice::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = Country::all()->pluck('id')->toArray();
        $zones = TimeZone::all()->pluck('id')->toArray();
        $user= User::factory()->create();
        $user->assignRole('processing_officer');
        return [
            'name' => fake()->company(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'phone' => fake()->e164PhoneNumber(),
            'country_id' => fake()->randomElement($countries),
            'time_zone_id' => fake()->randomElement($zones),
            'user_id' => $user->id,
        ];
    }
}
