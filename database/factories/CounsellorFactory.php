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
        $branches = Branch::all()->pluck('id')->toArray();
        $user = User::factory()->create();
        $user->assignRole('counsellor');
        $isProcessingOfficer = fake()->randomElement([true, false]);
        if ($isProcessingOfficer) {
            $user->assignRole('processing_officer');
        }
        return [
            'branch_id' => fake()->randomElement($branches),
            'is_processing_officer' => $isProcessingOfficer,
            'user_id' => $user->id,
        ];
    }
}
