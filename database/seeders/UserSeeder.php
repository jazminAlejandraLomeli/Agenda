<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        $user = [
            'user_name' => 'read',
            'name' => 'Guest User',
            'password' => bcrypt('Secret@1'),
            'status' => 1,
            'group_id' => 1,
        ];

        $role = [            
            'name' => 'read',
            'guard_name' => 'web'
        ];

        Role::create($role);
        $user = User::create($user)->assignRole('read');


        // $permission = Permission::create($permission);
        // User::where('user_name', 'CTA')->first()->givePermissionTo($permission);

        
    }
}
