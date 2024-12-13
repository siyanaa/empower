<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run()
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        //create an superadmin user
        $superAdminUser = User::create([
            'name' => "superadmin",
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $superAdminRole = Role::where('name', 'superadmin')->first();
        $superAdminUser->assignRole($superAdminRole);


        // Create an admin user
        $adminUser = User::create([
            'name' => "admin",
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        // Assign the admin role to the admin user
        $adminRole = Role::where('name', 'admin')->first();
        $adminUser->assignRole($adminRole);
    }

}