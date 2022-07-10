<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Cliente>
 */
class ClienteFactory extends Factory
{
    use WithFaker;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'telefone' => $this->faker->cellphoneNumber(),
            'cpf' => $this->faker->cpf(false),
            'placa_do_carro' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];
    }
}
