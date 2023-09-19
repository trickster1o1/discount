<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'phone' => '9841234567',
            'password' => 'password',
            'role_id' => Role::where('role_code', 'SUPERADMIN')->first()->id,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
