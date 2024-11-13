<?php

namespace Database\Factories;

use App\Enums\FollowupMode;
use App\Enums\LeadStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowupFactory extends Factory
{

    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();
        return [
            'remarks' => $this->faker->realText(),
            'lead_type' => $this->faker->randomElement(
                LeadStatus::cases()
            ),
            'follow_up_mode' => $this->faker->randomElement(
                FollowupMode::cases()
            ),
            'follow_up_date' => $this->faker->date(),
            'time' => json_encode([
                'hour' => $this->faker->numberBetween(0, 13),
                'minute' => $this->faker->numberBetween(0, 60),
                'zone' => $this->faker->randomElement(['am', 'pm']),
            ]),
            'added_by' => $this->faker->randomElement($users),
        ];
    }
}
