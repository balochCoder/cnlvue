<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();
        $newUser = User::factory()->create();
        $roles = ['counsellor','front_office','processing_officer'];
        $role = array_rand($roles);

        $newUser->assignRole($roles[$role]);
        return [
            'title' => $this->faker->word(),
            'file' => $this->faker->filePath(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TaskStatus::cases()),
            'assigned_to' => $newUser->id,
            'assigned_by' => $this->faker->randomElement($users),
            'start_date' => $start = $this->faker->date(),
            'due_date' => Carbon::parse($start)->addDays(rand(1, 30)),
        ];
    }
}
