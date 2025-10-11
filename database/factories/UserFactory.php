<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $groups = Group::all();
        
        return [
            'name' => fake()->name(),            
            'user_name' => fake()->userName(),
            'status' => fake()->randomElement([1, 0]),
            'password' => static::$password ??= Hash::make('password'),            
            'group_id' => fake()->randomElement($groups->pluck('id')->toArray()),
        ];
    }
   
}
