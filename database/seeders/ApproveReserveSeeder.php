<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ApproveReserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userSuper = User::where('group_id', 2)
            ->orWhere('group_id', 3)
            ->get();


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
        
        // Permission::create(['name' => 'approve reserve']);
        $permissionGetcta = Permission::whereIn('name',$permissionCTA)->get();

        foreach ($userSuper as $user) {
            $user->syncPermissions($permissionGetcta);
        }
    }
}
