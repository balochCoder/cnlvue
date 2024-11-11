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
            'representing_institution_id' => $this->faker->randomElement($institutions),
            'title' => $this->faker->sentence(3),
            'level' => $this->faker->randomElement(CourseLevel::cases()),
            'duration' => json_encode([
                'year'=>$this->faker->numberBetween(1, 5),
                'month'=>$this->faker->numberBetween(0, 11),
                'weeks'=>$this->faker->numberBetween(0, 4),

            ]),
            'start_date' => $start =  $this->faker->dateTimeBetween('now', '+1 years'),
            'end_date' => fn() => Carbon::parse($start)->addYears(rand(1, 5)),
            'campus' => $this->faker->city(),
            'awarding_body' => $this->faker->optional()->company(),
            'fee' => $this->faker->randomFloat(2, 1000, 50000),
            'application_fee' => $this->faker->optional()->randomFloat(2, 50, 500),
            'currency_id' => $currency->id,
            'monthly_living_cost' => $this->faker->optional()->numberBetween(500, 5000),
            'part_time_work_details' => $this->faker->optional()->paragraph(),
            'course_benefits' => $this->faker->optional()->paragraph(),
            'general_eligibility' => $this->faker->optional()->paragraph(),
            'quality_of_applicant' => $this->faker->randomElement(ApplicantDesired::cases()),
            'course_category' => json_encode($this->faker->randomElements(CourseCategories::cases(),3)),
            'modules' => json_encode($this->faker->randomElements(['Module A', 'Module B', 'Module C'],  3)),
            'intake' => json_encode($this->faker->randomElements([
                'January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December',
            ], 4))
        ];
    }
}
