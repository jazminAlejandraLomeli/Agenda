<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Protocolo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\protocolo>
 */
class ProtocoloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $events = Event::select('id')->get();
        $random = $events->random()->id;
        $protocoloExists = Protocolo::where('event_id', $random)->exists();

        if ($protocoloExists) {
            exit();
        }

        // No random data is generated the event_id is required
    
        return [
            'event_id' => $events->random()->id,
            'tel_extension' => $this->faker->phoneNumber,
            'notes_cta' => $this->faker->paragraph,
            'notes_protocolo' => $this->faker->paragraph,
            'notes_general_service' => $this->faker->paragraph,
            'link' => $this->faker->url,
        ];
    }
}
