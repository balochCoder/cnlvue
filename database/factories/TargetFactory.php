<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TargetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();
        return [
            'description' => $this->faker->paragraph(),
            'number' => $this->faker->numberBetween(1, 10),
            'year' => $this->faker->year(),
            'added_by' => $this->faker->randomElement($users)
        ];
    }
}
