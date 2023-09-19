<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Superadmin',
            'role_code' => 'SUPERADMIN',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Role::create([
            'name' => 'Developer',
            'role_code' => 'DEVELOPER',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Role::create([
            'name' => 'Editor',
            'role_code' => 'EDITOR',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Role::create([
            'name' => 'Viewer',
            'role_code' => 'VIEWER',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
