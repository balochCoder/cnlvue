<?php

namespace Database\Factories;

use App\Enums\FollowupMode;
use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowupFactory extends Factory
{

    public function definition(): array
    {
        $leads = Lead::all()->pluck('id')->toArray();
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
                'am/pm' => $this->faker->randomElement(['am', 'pm']),
            ]),
            'lead_id' => $this->faker->randomElement($leads),
            'added_by' => $this->faker->randomElement($users),
        ];
    }
}
