<?php

namespace Database\Factories;

use App\Enums\ApplicantDesired;
use App\Enums\CourseCategories;
use App\Enums\CourseLevel;
use App\Models\Course;
use App\Models\Currency;
use App\Models\RepresentingInstitution;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class CourseFactory extends Factory
{
    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $institutions = RepresentingInstitution::all()->pluck('id')->toArray();
        $currency = Currency::query()->where('id', 49)->firstOrFail();
        return [
            'representing_institution_id' => fake()->randomElement($institutions),
            'title' => fake()->sentence(3),
            'level' => fake()->randomElement(CourseLevel::cases()),
            'duration' => json_encode([
                'year'=>fake()->numberBetween(1, 5),
                'month'=>fake()->numberBetween(0, 11),
                'weeks'=>fake()->numberBetween(0, 4),

            ]),
            'start_date' => $start =  fake()->dateTimeBetween('now', '+1 years'),
            'end_date' => fn() => Carbon::parse($start)->addYears(rand(1, 5)),
            'campus' => fake()->city(),
            'awarding_body' => fake()->optional()->company(),
            'fee' => fake()->randomFloat(2, 1000, 50000),
            'application_fee' => fake()->optional()->randomFloat(2, 50, 500),
            'currency_id' => $currency->id,
            'monthly_living_cost' => fake()->optional()->numberBetween(500, 5000),
            'part_time_work_details' => fake()->optional()->paragraph(),
            'course_benefits' => fake()->optional()->paragraph(),
            'general_eligibility' => fake()->optional()->paragraph(),
            'quality_of_applicant' => fake()->optional()->randomElement(ApplicantDesired::cases()),
            'course_category' => json_encode(fake()->randomElements(CourseCategories::cases(),3)),
            'modules' => json_encode(fake()->randomElements(['Module A', 'Module B', 'Module C'],  3)),
            'intake' => json_encode(fake()->randomElements([
                'January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December',
            ], 4))
        ];
    }
}
