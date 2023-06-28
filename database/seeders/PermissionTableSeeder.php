<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-module',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'role-module',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'master-module',
            'master-list',
            'master-create',
            'master-edit',
            'master-delete',

            'project-module',
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',

            'task-module',
            'task-list',
            'task-create',
            'task-edit',
            'task-delete',
        ];

        foreach ($permissions as $permission) {
            $model = Permission::whereName($permission);
            if ($model->count() == 0) {
                Permission::create(['name' => $permission]);
            }

        }
    }
}
