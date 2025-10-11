<?php

namespace Database\Factories;

use App\Models\Cta;
use App\Models\Event;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cta>
 */
class CTAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

  
    public function definition(): array
    {




         // Define el conjunto de valores estáticos
         $events = Event::select('id')->get();
         $random = $events->random()->id;
         $cta = CTA::where('event_id', $random)->exists();

         if ($cta) {
             exit();
         }
 
         // Obtén un semestre aleatorio
         $semesters = Semester::pluck('id'); // Solo obtén los IDs, más eficiente
 
         return [
             'event_id' => $random,
             'email' => $this->faker->email,
             'num_participants' => $this->faker->numberBetween(1, 100),
             'published' => $this->faker->boolean,
             'semester_id' => $this->faker->randomElement($semesters->toArray()), // Selecciona un semestre aleatorio
         ];
    }
}
