<?php

namespace Database\Seeders;

use App\Models\Cta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CTASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cta::factory(30)->create();
    }
}
