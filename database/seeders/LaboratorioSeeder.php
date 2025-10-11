<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class LaboratorioSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 4, 'type' => 'Laboratorio'],
        ];


        Group::insert($data);


      //  User::create([
        //     // 'id' => 1,
        //     'user_name' => 'Laboratorio',
        //     'name' => 'Jorge Olmos',
        //     'password' => bcrypt('Aa@1'),
        //     'status' => 1,
        //     'group_id' => 4,
        // ])->assignRole(2);


        $permissions = [
            'approve laboratory',
            // 'update reserve laboratory',
            // 'delete reserve laboratory',
            // 'reserve laboratory',
            // 'reserve laboratory-create event',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        $userLabs = User::where('user_name', 'Laboratorio')->first();

        $permissionLabs = [
            'approve laboratory',
            // 'reserve laboratory',
            // 'create event type',
            // 'create dependency',
            // 'create place',
            // 'delete reserve laboratory',
            // 'update event type',
            // 'update dependency',
            // 'update place',
            // 'view event type',
            // 'view dependency',
            // 'view place',
            // 'update reserve laboratory',
 
            // 'reserve laboratory',
            // 'reserve laboratory-create event'
        ];

        $permissionGetLabs = Permission::whereIn('name', $permissionLabs)->get();
        $userLabs->givePermissionTo($permissionGetLabs);
    }
}
