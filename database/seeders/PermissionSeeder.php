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
        $create_projects = Permission::create(['name' => 'create projects']);
        $create_tasks = Permission::create(['name' => 'create tasks']);
        $assign_tasks = Permission::create(['name' => 'assign tasks']);

        $edit_status_own_tasks = Permission::create(['name' => 'edit status own tasks']);

        // assign permissions to roles
        $pm_role->syncPermissions([$create_customers, $create_projects, $create_tasks, $assign_tasks]);
        $dev_role->syncPermissions([$edit_status_own_tasks]);
    }
}
