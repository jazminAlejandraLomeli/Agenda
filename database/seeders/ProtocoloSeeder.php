<?php

namespace Database\Seeders;

use App\Models\Protocolo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProtocoloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Protocolo::factory(20)->create();
    }
}
