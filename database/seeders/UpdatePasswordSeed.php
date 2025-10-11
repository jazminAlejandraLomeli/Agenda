<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userall = User::all();

        foreach($userall as $user) {
            $user->update([
                'password' => Hash::make('Cu@lt0s.'),
            ]);
        }
    }
}
