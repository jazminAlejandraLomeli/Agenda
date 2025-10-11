<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions =[
            'create event',
            'update event',
            'update reserve classroom',
            'delete event',
            'delete reserve classroom',
            'reserve classroom',
            'reserve classroom-create event',
            'view event type',
            'view dependency',
            'view place',
            'view user',
            'create event type',
            'create dependency',
            'create place',
            'update event type',
            'update dependency',
            'update place',
            'create user',
            'reset password',
            'update user',
            'delete user',
            'confirm event',
            'approve reserve',
        ];

        foreach($permissions as $permission){
            Permission::create(['name'=> $permission]);
        }

        
    }
}
