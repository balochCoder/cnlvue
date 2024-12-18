<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Counsellor;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);


        $user2 = User::factory()->create([
            'name' => 'Counsellor',
            'email' => 'counsellor@example.com',
        ]);
        $user3 = User::factory()->create([
            'name' => 'Branch',
            'email' => 'branch@example.com',
        ]);

        $branch = Branch::factory()->create();
        Counsellor::query()->create([
            'branch_id' =>  $branch->id,
            'user_id' => $user2->id,
        ]);

        Branch::factory()->create([
            'user_id' => $user3->id,
        ]);
        $user1->assignRole('super admin');
        $user2->assignRole('counsellor');
        $user3->assignRole('branch');
    }
}
