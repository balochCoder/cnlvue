<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\FrontOffice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FrontOfficeFactory extends Factory
{
   protected $model = FrontOffice::class;
    public function definition(): array
    {
        $branches = Branch::all()->pluck('id')->toArray();
        $user = User::factory()->create();
        $user->assignRole('front office');
        return [
            'branch_id' => $this->faker->randomElement($branches),
            'edit_leads' => $this->faker->randomElement([true, false]),
            'user_id' => $user->id,
        ];
    }
}
