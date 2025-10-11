<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class ResetPasswordPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();        
        
        foreach($users as $user){
            $seActualiza = $user->update([
                'password' => bcrypt($_ENV['DEFAULT_PASSWORD'])
            ]);           
        }

        $userSuper = User::where('group_id', 3)->get();
        $permissionSuper = Permission::all();


        foreach($userSuper as $user){          
            $user->syncPermissions([]);
            $user->givePermissionTo($permissionSuper);
        }

        $userProtocolo = User::where('group_id', 1)->get();

        $permissionProtocolo = [
            'create event',
            'create event type',
            'update event',
            'delete event',
            'create dependency',
            'create place',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
        ];

        $permissionGetProtocolo = Permission::whereIn('name',$permissionProtocolo)->get();
        foreach($userProtocolo as $user){  
            $user->syncPermissions([]);          
            $user->givePermissionTo($permissionGetProtocolo);
        }

        $permissionCTA = [
            'reserve classroom',
            'create event type',
            'create dependency',
            'create place',
            'delete reserve classroom',
            'update event type',
            'update dependency',
            'update place',
            'view event type',
            'view dependency',
            'view place',
            'update reserve classroom',
            'approve reserve',
        ];

        $userCTA = User::where('group_id', 2)->get();
        $permissionGetCTA = Permission::whereIn('name',$permissionCTA)->get();

        foreach($userCTA as $user){    
            $user->syncPermissions([]);        
            $user->givePermissionTo($permissionGetCTA);
        }
    }
}
