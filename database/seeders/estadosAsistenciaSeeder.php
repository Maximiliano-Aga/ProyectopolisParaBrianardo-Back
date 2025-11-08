<?php

namespace Database\Seeders;

use App\Models\estadosAsistencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class estadosAsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        estadosAsistencia::factory()->count(3)->create();
    }
}
