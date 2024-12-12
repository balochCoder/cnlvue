<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Associate;
use App\Models\Branch;
use App\Models\Counsellor;
use App\Models\Course;
use App\Models\FrontOffice;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\ProcessingOffice;
use App\Models\Student;
use App\Models\Remark;
use App\Models\RepresentingCountry;

use App\Models\RepresentingInstitution;
use App\Models\Target;
use App\Models\Task;
use App\Models\TaskRemark;
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
            CountrySeeder::class,
            CurrencySeeder::class,
            TimeZoneSeeder::class,
            UserSeeder::class,
            LeadSourceSeeder::class,

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

        RepresentingInstitution::factory(1)->create();
        Course::factory(5)->create();
        $branches = Branch::factory(5)->create();
        $branches->each(function ($branch) {
            Counsellor::factory(5)
                ->for($branch)
                ->hasAttached(
                    RepresentingInstitution::factory(2)->create(),
                    [],
                    'institutions'
                )
                ->has(Remark::factory(10))
                ->has(Target::factory(5))
                ->create();

        });

        FrontOffice::factory(10)->create();
        ProcessingOffice::factory(10)
            ->hasAttached(
                RepresentingInstitution::factory(2)->create(),
                [],
                'institutions'
            )
            ->create();
        Associate::factory(10)->create();
        LeadSource::factory(10)->create();
        $branches->each(function ($branch) {
            Lead::factory(10)
                ->for($branch)
                ->hasFollowups(4)
                ->create()
                ->each(function ($lead) use ($branch) {
                    $lead->counsellors()->attach($branch->counsellors);
                });
        });
        Task::factory(10)->create();
        TaskRemark::factory(10)->create();
        Student::factory(10)->create();
        Application::factory(10)->create();
    }
}
