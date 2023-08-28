<?php

namespace Database\Factories;

use App\Models\Alumnos;
use App\Models\Cursos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CursosAlumnos>
 */
class CursosAlumnosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumnos_id' => Alumnos::all()->random(),
            'cursos_id' => Cursos::all()->random(),
            'asistencia' => NULL,
            'state' => 1,
        ];
    }
}
