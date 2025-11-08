<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\estadosAsistencia>
 */
class estadosAsistenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'estado' => $this->faker->unique()->word(),
            'valor' => $this->faker->unique()->randomFloat(2, 0, 100),
        ];
    }

    public function configure():static
    {
        return $this->sequence([
            'estado' => 'Presente',
            'valor' => 1.0,
        ], [
            'estado' => 'Ausente',
            'valor' => 0.0,
        ], [
            'estado' => 'Media Falta',
            'valor' => 0.5,
        ]);
            // Lógica adicional después de crear un estado de asistencia, si es necesario
        
    }
}
