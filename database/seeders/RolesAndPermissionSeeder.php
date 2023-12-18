<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Administrator',
            'email' => 'marklistermueblas3@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Mark Lister Mueblas',
            'email' => 'student@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $admin = Role::create(['name' => 'administrator']);
        $user = Role::create(['name' => 'student']);

        $user1->assignRole($admin);
        $user2->assignRole($user);
    }
}
