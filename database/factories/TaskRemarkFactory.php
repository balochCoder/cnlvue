<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskRemarkFactory extends Factory
{

    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();
        $tasks = Task::all()->pluck('id')->toArray();
        return [
            'task_id' => $this->faker->randomElement($tasks),
            'remark'=> $this->faker->sentence(),
            'created_by'=> $this->faker->randomElement($users),
        ];
    }
}
