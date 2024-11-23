<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class QuotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $leads = Lead::all()->pluck('id')->toArray();
        $users = User::role('counsellor')->pluck('id')->toArray();
        return [
            'lead_id' => $this->faker->randomElement($leads),
            'student_gender' => $this->faker->randomElement(['Male', 'Female']),
            'student_title' => $this->faker->randomElement(['Mr', 'Mrs', 'Ms', 'Miss']),
            'student_nationality' => $this->faker->country(),
            'is_valid_passport' => $valid = $this->faker->boolean(),
            'student_passport' => $valid ? $this->faker->randomNumber() : null,
            'student_image' => $this->faker->imageUrl(),
            'student_marital_status' => $this->faker->randomElement(['Single', 'Married']),
            'permanent_address' => json_encode([
                'address' => $this->faker->address(),
                'city' => $this->faker->city(),
                'state' => $this->faker->city()
            ]),
            'correspondence_address' => json_encode([
                'address' => $this->faker->address(),
                'city' => $this->faker->city(),
                'state' => $this->faker->city()
            ]),
            'education_history' => json_encode([
                [
                    'institution' => $this->faker->word(),
                    'qualification' => $this->faker->word(),
                    'year' => $this->faker->year(),
                    'grade' => $this->faker->word(),
                    'file' => $this->faker->imageUrl(),
                ], [
                    'institution' => $this->faker->word(),
                    'qualification' => $this->faker->word(),
                    'year' => $this->faker->year(),
                    'grade' => $this->faker->word(),
                    'file' => $this->faker->imageUrl(),
                ]
            ]),
            'english_language' => json_encode([
                'ielts' => [
                    'listening' => $this->faker->numberBetween(1, 8),
                    'speaking' => $this->faker->numberBetween(1, 8),
                    'reading' => $this->faker->numberBetween(1, 8),
                    'writing' => $this->faker->numberBetween(1, 8),
                    'score' => $this->faker->numberBetween(1, 8),
                    'date' => $this->faker->date(),
                    'additional' => $this->faker->sentence(),
                    'file' => $this->faker->imageUrl(),
                ],
                'toefl' => [
                    'listening' => $this->faker->numberBetween(1, 8),
                    'speaking' => $this->faker->numberBetween(1, 8),
                    'reading' => $this->faker->numberBetween(1, 8),
                    'writing' => $this->faker->numberBetween(1, 8),
                    'score' => $this->faker->numberBetween(1, 8),
                    'date' => $this->faker->date(),
                    'additional' => $this->faker->sentence(),
                    'file' => $this->faker->imageUrl(),
                ]
            ]),
            'work_experience' => json_encode([
                [
                    'employer' => $this->faker->company(),
                    'position' => $this->faker->jobTitle(),
                    'period' => $this->faker->numberBetween(1, 10),
                    'responsibilities' => $this->faker->text(),
                    'file' => $this->faker->imageUrl(),
                ]
            ]),
            'references' => json_encode([
                [
                    'name' => $this->faker->name(),
                    'designation' => $this->faker->jobTitle(),
                    'institution' => $this->faker->company(),
                    'email' => $this->faker->unique()->safeEmail(),
                    'phone' => $this->faker->phoneNumber(),
                    'address' => $this->faker->address(),
                    'city' => $this->faker->city(),
                    'state' => $this->faker->city(),
                    'country' => $this->faker->country(),
                    'zip' => $this->faker->postcode(),
                ]
            ]),
            'statement_of_purpose' => json_encode([
                'sop' => $this->faker->paragraph(),
                'file' => $this->faker->imageUrl(),
            ]),
            'is_accommodation_required' => $this->faker->boolean(),
            'is_medical_required' => $medical = $this->faker->boolean(),
            'medical_history' => $medical ? $this->faker->paragraph() : null,
            'additional_information' => $this->faker->paragraph(),
            'additional_documents' => json_encode([
                [
                    'title' => $this->faker->word(),
                    'file' => $this->faker->imageUrl(),
                ],
                [
                    'title' => $this->faker->word(),
                    'file' => $this->faker->imageUrl(),
                ]
            ]),
            'added_by' => $this->faker->randomElement($users)
        ];
    }
}
