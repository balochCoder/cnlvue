<?php

namespace Database\Factories;

use App\Enums\DownloadCSV;
use App\Models\Branch;
use App\Models\RepresentingCountry;
use App\Models\TimeZone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = RepresentingCountry::all()->pluck('id')->toArray();
        $zones = TimeZone::all()->pluck('id')->toArray();
        $user= User::factory()->create();
        $user->assignRole('branch');
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country_id' => $this->faker->randomElement($countries),
            'time_zone_id' => $this->faker->randomElement($zones),
            'branch_email' => $this->faker->companyEmail,
            'branch_phone' => $this->faker->phoneNumber,
            'branch_website' => $this->faker->url,
            'download_csv' => $this->faker->randomElement(DownloadCSV::cases()),
            'contact_person_name' => $this->faker->name,
            'contact_person_designation' => $this->faker->jobTitle,
            'contact_person_phone' => $this->faker->phoneNumber,
            'contact_person_mobile' => $this->faker->phoneNumber,
            'contact_person_whatsapp' => $this->faker->e164PhoneNumber,
            'contact_person_skype' => $this->faker->userName,
            'is_active'=> true,
            'user_id' => $user->id,
        ];
    }
}
