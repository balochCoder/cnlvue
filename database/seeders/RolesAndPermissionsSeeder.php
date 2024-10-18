<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $arrayOfPermissionsNames = [
            'role-view',
            'role-create',
            'role-update',
            'role-delete',
            'role-restore',
            'role-force-delete',

            'permission-view',
            'permission-create',
            'permission-update',
            'permission-delete',
            'permission-restore',
            'permission-force-delete',

            'country-view',
            'country-create',
            'country-update',
            'country-delete',
            'country-restore',
            'country-force-delete',

            'representing_country-view',
            'representing_country-create',
            'representing_country-update',
            'representing_country-delete',
            'representing_country-restore',
            'representing_country-force-delete',

            'representing_institution-view',
            'representing_institution-create',
            'representing_institution-update',
            'representing_institution-delete',
            'representing_institution-restore',
            'representing_institution-force-delete',

            'application_process-view',
            'application_process-create',
            'application_process-update',
            'application_process-delete',
            'application_process-restore',
            'application_process-force-delete',

            'course-view',
            'course-create',
            'course-update',
            'course-delete',
            'course-restore',
            'course-force-delete',

            'branch-view',
            'branch-create',
            'branch-update',
            'branch-delete',
            'branch-restore',
            'branch-force-delete',

            'counsellor-view',
            'counsellor-create',
            'counsellor-update',
            'counsellor-delete',
            'counsellor-restore',
            'counsellor-force-delete',

            'front_office-view',
            'front_office-create',
            'front_office-update',
            'front_office-delete',
            'front_office-restore',
            'front_office-force-delete',

            'processing_office-view',
            'processing_office-create',
            'processing_office-update',
            'processing_office-delete',
            'processing_office-restore',
            'processing_office-force-delete',

            'associate-view',
            'associate-create',
            'associate-update',
            'associate-delete',
            'associate-restore',
            'associate-force-delete',
        ];
        $permissions = collect($arrayOfPermissionsNames)->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        Permission::query()->insert($permissions->toArray());
        Role::create(['name' => 'super admin','guard_name'=>'web']);

        Role::create(['name' => 'admin','guard_name'=>'web'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'counsellor','guard_name'=>'web']);
        Role::create(['name' => 'branch','guard_name'=>'web']);
        Role::create(['name' => 'processing officer','guard_name'=>'web']);
        Role::create(['name' => 'front office','guard_name'=>'web']);
        Role::create(['name' => 'associate','guard_name'=>'web']);

    }
}
