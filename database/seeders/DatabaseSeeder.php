<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Counsellor;
use App\Models\Course;
use App\Models\FrontOffice;
use App\Models\ProcessingOffice;
use App\Models\RepresentingCountry;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RepresentingInstitution;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
            TimeZoneSeeder::class,
        ]);
        RepresentingCountry::factory(10)->create()->each(function (RepresentingCountry $country) {
            $country->applicationProcesses()->create([
                'name' => 'New',
                'notes' => 'This is new Status Note'
            ]);
        });

        RepresentingInstitution::factory(10)->create();
        Course::factory(50)->create();
        Branch::factory(5)->create();
        Counsellor::factory(5)->create();
        FrontOffice::factory(10)->create();
        ProcessingOffice::factory(10)->create();
    }
}
