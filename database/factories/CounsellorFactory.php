<?php

namespace Database\Factories;

use App\Enums\DownloadCSV;
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
        $user= User::factory()->create();
        $user->assignRole('counsellor');
        return [
            'branch_id' => $this->faker->randomElement($branches),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'whatsapp' =>$this->faker->e164PhoneNumber,
            'download_csv' => $this->faker->randomElement(DownloadCSV::cases()),
            'user_id' => $user->id,
        ];
    }
}
