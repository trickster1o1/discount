<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'List',
            'permission_code' => 'INDEX',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Permission::create([
            'name' => 'Create',
            'permission_code' => 'CREATE',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Permission::create([
            'name' => 'Read',
            'permission_code' => 'SHOW',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Permission::create([
            'name' => 'Update',
            'permission_code' => 'UPDATE',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Permission::create([
            'name' => 'Delete',
            'permission_code' => 'DESTROY',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Permission::create([
            'name' => 'Assign Permission',
            'permission_code' => 'ASSIGN',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
