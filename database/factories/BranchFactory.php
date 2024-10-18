<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\RepresentingCountry;
use App\Models\TimeZone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        $countries = RepresentingCountry::all()->pluck('id')->toArray();
        $zones = TimeZone::all()->pluck('id')->toArray();
        $user= User::factory()->create();
        $user->assignRole('branch');
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state'=> $this->faker->city(),
            'country_id' => $this->faker->randomElement($countries),
            'time_zone_id' => $this->faker->randomElement($zones),
            'branch_email' => $this->faker->companyEmail(),
            'branch_phone' => $this->faker->phoneNumber(),
            'branch_website' => $this->faker->url(),
            'user_id' => $user->id,
        ];
    }
}
