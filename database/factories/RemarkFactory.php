<?php

namespace Database\Factories;

use App\Models\Counsellor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RemarkFactory extends Factory
{

    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();
        return [
            'remarks' => $this->faker->sentence(),
            'add_date' => $this->faker->date(),
            'added_by' => $this->faker->randomElement($users),
        ];
    }
}
