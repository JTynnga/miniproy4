<?php

namespace Database\Factories;

use App\Models\Docentes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\ForeignKeyDefinition;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cursos>
 */
class CursosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // $factory->define(App\Post::class, function ($faker) 
    public function definition(): array
    {
        return [
            'name' => fake()->colorName(),
            'docente_id' => Docentes::all()->random(),
            'state' => 1,
        ];
    }
}
