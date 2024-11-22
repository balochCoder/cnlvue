<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Counsellor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class CounsellorFactory extends Factory
{
    protected $model = Counsellor::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('counsellor');
        $isProcessingOfficer = $this->faker->randomElement([true, false]);
        return [
            'is_processing_officer' => $isProcessingOfficer,
            'user_id' => $user->id,
        ];
    }
}
