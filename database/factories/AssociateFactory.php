<?php

namespace Database\Factories;

use App\Enums\AssociateCategories;
use App\Models\Branch;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class AssociateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = Country::all()->pluck('id')->toArray();
        $branches = Branch::all()->pluck('id')->toArray();
        $user = User::factory()->create();
        $user->assignRole('associate');
        return [
            'associate_name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'phone' => $this->faker->e164PhoneNumber(),
            'website' => $this->faker->url(),
            'terms_of_association' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(AssociateCategories::cases()),
            'country_id' => $this->faker->randomElement($countries),
            'branch_id' => $this->faker->randomElement($branches),
            'user_id' => $user->id,
        ];
    }
}
