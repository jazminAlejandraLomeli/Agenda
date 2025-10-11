<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AssigPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userSuper = User::where('user_name', 'Super')->first();

        $userSuper->givePermissionTo(Permission::all());

        $userProtocolo = User::where('user_name','protocolo')->first();
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
        $userProtocolo->givePermissionTo($permissionGetProtocolo);

        $userCTA = User::where('user_name','CTA')->first();

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

        $permissionGetCTA = Permission::whereIn('name',$permissionCTA)->get();
        $userCTA->givePermissionTo($permissionGetCTA);

    }
}
