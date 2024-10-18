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
        $user->assignRole('processing officer');
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'office_phone' => $this->faker->e164PhoneNumber(),
            'country_id' => $this->faker->randomElement($countries),
            'time_zone_id' => $this->faker->randomElement($zones),
            'user_id' => $user->id,
        ];
    }
}
