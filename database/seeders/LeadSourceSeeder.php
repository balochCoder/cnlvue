<?php

namespace Database\Seeders;

use App\Models\LeadSource;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        LeadSource::create([
            'source_name' => 'associate',
            'added_by' => $user->id,
        ]);
    }
}
