<?php

namespace Database\Factories\Care;

use App\Models\Care\Paciente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a este factory.
     *
     * @var string
     */
    protected $model = Paciente::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener un 'user_id' aleatorio de usuarios con rol 'admin' o 'medico'
        $userId = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'medico']);
        })->inRandomOrder()->first()->id;

        // Obtener un 'responsable_id' aleatorio de usuarios con rol 'cliente'
        $responsableId = User::whereHas('roles', function ($query) {
            $query->where('name', 'cliente');
        })->inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,
            'responsable_id' => $responsableId,
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'species' => $this->faker->randomElement(['Perro', 'Gato', 'Conejo', 'Ave']),
            'race' => $this->faker->word,
            'sex' => $this->faker->randomElement(['Macho', 'Hembra']),
            'birth_date' => $this->faker->date(),
            'weight' => $this->faker->randomFloat(2, 1, 50), // Peso aleatorio entre 1 y 50 kg
            'hair' => $this->faker->randomElement(['Corto', 'Largo', 'Rizado']),
            'chip_number' => $this->faker->unique()->randomNumber(8),
            'other_features' => $this->faker->sentence,
            'zootechnical_purpose' => $this->faker->randomElement(['Mascota', 'Trabajo', 'Reproducción']),
            'provenance' => $this->faker->city,
        ];


    }
}
