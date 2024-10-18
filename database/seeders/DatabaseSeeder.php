<?php

namespace Database\Seeders;

use App\Models\Associate;
use App\Models\Branch;
use App\Models\Counsellor;
use App\Models\Course;
use App\Models\Followup;
use App\Models\FrontOffice;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\ProcessingOffice;
use App\Models\Remark;
use App\Models\RepresentingCountry;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RepresentingInstitution;
use App\Models\Target;
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
            $process = $country->applicationProcesses()->create([
                'name' => 'New',
                'notes' => 'This is new Status Note'
            ]);
            $process->subStatuses()->create([
                'name' => 'The new',
            ]);
        });

        RepresentingInstitution::factory(10)->create();
        Course::factory(50)->create();
        Branch::factory(5)->create();
        $counsellors = Counsellor::factory(5)->hasAttached(
            RepresentingInstitution::factory(3)->create(),
            [],
            'institutions'
        )->has(
            Remark::factory(10)
        )->has(
            Target::factory(5)
        )->create();
        FrontOffice::factory(10)->create();
        ProcessingOffice::factory(10)->create();
        Associate::factory(10)->create();
        LeadSource::factory(10)->create();
        Lead::factory(5)->hasAttached($counsellors)->create();
        Followup::factory(5)->create();
    }
}
