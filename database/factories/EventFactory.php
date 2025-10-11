<?php

namespace Database\Factories;

use App\Models\Date;
use App\Models\Dependency_program;
use App\Models\Event;
use App\Models\Event_type;
use App\Models\Group;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $types = Event_type::select('id')->get();
        $dependencies_program = Dependency_program::select('id')->get();
        $places = Place::select('id')->get();
        $users = User::select('id')->get();
        $group_id = Group::select('id')->get();
        $dates = Date::select('id')->get();

        $random = $dates->random()->id;

        $eventWithSameDate = Event::where('date_id', $random)->exists();

        if ($eventWithSameDate) {
            exit();
        }

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'created_by' => $users->random()->id,
            'group_id' => $group_id->random()->id,
            'type_id' => $types->random()->id,
            'dependency_program_id' => $dependencies_program->random()->id,
            'place_id' => $places->random()->id,
            'date_id' => $random
        ];
    }
}
