<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // defining project roles
        $pm_role = Role::create(['name' => 'project manager']);
        $dev_role = Role::create(['name' => 'developer']);

        // defining project permissions
        $create_customers = Permission::create(['name' => 'create customers']);
        $update_customers = Permission::create(['name' => 'update customers']);
        $create_projects = Permission::create(['name' => 'create projects']);
        $update_projects = Permission::create(['name' => 'update projects']);
        $update_own_projects = Permission::create(['name' => 'update own projects']);
        $create_tasks = Permission::create(['name' => 'create tasks']);
        $create_own_project_tasks = Permission::create(['name' => 'create own project tasks']);
        $update_tasks = Permission::create(['name' => 'update tasks']);
        $update_own_project_tasks = Permission::create(['name' => 'update own project tasks']);

        $update_status_own_tasks = Permission::create(['name' => 'update status own tasks']);

        // assign permissions to roles
        $pm_role->syncPermissions([$create_customers, $update_customers, $create_projects, $update_own_projects, $create_own_project_tasks, $update_own_project_tasks]);
        $dev_role->syncPermissions([$update_status_own_tasks]);
    }
}
