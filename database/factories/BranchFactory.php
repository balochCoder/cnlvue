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
            'name' => fake()->company(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'country_id' => fake()->randomElement($countries),
            'time_zone_id' => fake()->randomElement($zones),
            'branch_email' => fake()->companyEmail(),
            'branch_phone' => fake()->phoneNumber(),
            'branch_website' => fake()->url(),
            'user_id' => $user->id,
        ];
    }
}
