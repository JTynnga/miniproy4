<?php

namespace Database\Seeders;

use App\Models\CursosAlumnos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursosAlumnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CursosAlumnos::factory(10)->create();
    }
}
