<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class carrerasConMateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {

        // 1. Crear la Carrera: Ingeniería de Sistemas
        $sistemas = Carrera::create([
            'carNombre' => 'Ingeniería de Sistemas',
        ]);

        // 1.1. Asignar Materias a Ingeniería de Sistemas
        $sistemas->materias()->createMany([
            ['matNombre' => 'Introducción a la Programación'],
            ['matNombre' => 'Estructuras de Datos'],
            ['matNombre' => 'Bases de Datos'],
            ['matNombre' => 'Arquitectura de Computadoras'],
        ]);
        
        // 2. Crear la Carrera: Licenciatura en Administración
        $administracion = Carrera::create([
            'carNombre' => 'Licenciatura en Administración',
        ]);

        // 2.1. Asignar Materias a Licenciatura en Administración
        $administracion->materias()->createMany([
            ['matNombre' => 'Contabilidad Financiera'],
            ['matNombre' => 'Principios de Economía'],
            ['matNombre' => 'Derecho Empresarial'],
            ['matNombre' => 'Gestión de Recursos Humanos'],
        ]);

        // 3. Crear la Carrera: Diseño Gráfico
        $diseno = Carrera::create([
            'carNombre' => 'Diseño Gráfico',
        ]);

        // 3.1. Asignar Materias a Diseño Gráfico
        $diseno->materias()->createMany([
            ['matNombre' => 'Historia del Arte'],
            ['matNombre' => 'Ilustración Digital'],
            ['matNombre' => 'Tipografía'],
        ]);
    }
}
