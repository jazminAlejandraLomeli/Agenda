<?php

namespace Database\Factories;

use App\Models\Date;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Date>
 */
class DateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'date_start' => $this->faker->dateTimeBetween('2025-04-01 08:00:00', '2025-04-30 20:00:00'),
            'date_end' => $this->faker->dateTimeBetween('2025-04-01 08:00:00', '2025-04-30 20:00:00'),            
        ];
    }
}
