<?php

namespace Database\Factories;

use App\Enums\CourseCategories;
use App\Enums\CourseLevel;
use App\Enums\LeadStatus;
use App\Models\Branch;
use App\Models\Country;
use App\Models\LeadSource;
use App\Models\RepresentingInstitution;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $leadSources = LeadSource::all()->pluck('id')->toArray();
        $countries = Country::all()->pluck('id')->toArray();
        $institutions = RepresentingInstitution::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();
        return [
            'student_first_name' => $this->faker->firstName(),
            'student_last_name' => $this->faker->lastName(),
            'intake_of_interest_month' => $this->faker->monthName(),
            'intake_of_interest_year' => $this->faker->year(),
            'student_email' => $this->faker->unique()->safeEmail(),
            'student_phone' => $this->faker->phoneNumber(),
            'student_emergency_phone' => $this->faker->phoneNumber(),
            'student_mobile' => $this->faker->phoneNumber(),
            'estimated_budget' => $this->faker->numberBetween(1000, 10000),
            'course_level_of_interest' => $this->faker->randomElement(CourseLevel::cases()),
            'additional_info' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(LeadStatus::cases()),
            'course_category' => json_encode($this->faker->randomElements(CourseCategories::cases(), 3)),
            'date_of_birth' => $this->faker->date(),
            'student_skype' => $this->faker->userName(),
            'is_country_preferred' => $preferred = $this->faker->randomElement([true, false]),
            'lead_source_id' => $this->faker->randomElement($leadSources),
            'interested_country_id' => $preferred ? $this->faker->randomElement($countries) : null,
            'interested_institution_id' => $preferred ? $this->faker->randomElement($institutions) : null,
            'added_by' => $this->faker->randomElement($users),

        ];
    }
}
