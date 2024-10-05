<?php

namespace Database\Factories;

use App\Enums\DownloadCSV;
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
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country_id' => $this->faker->randomElement($countries),
            'time_zone_id' => $this->faker->randomElement($zones),
            'processing_office_phone' => $this->faker->phoneNumber,
            'download_csv' => $this->faker->randomElement(DownloadCSV::cases()),
            'contact_person_name' => $this->faker->name,
            'contact_person_designation' => $this->faker->jobTitle,
            'contact_person_phone' => $this->faker->phoneNumber,
            'contact_person_mobile' => $this->faker->phoneNumber,
            'contact_person_skype' => $this->faker->userName,
            'is_active'=> true,
            'user_id' => $user->id,
        ];
    }
}
