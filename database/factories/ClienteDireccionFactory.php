<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClienteDireccion>
 */
class ClienteDireccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dirid' => fake()->unique()->numberBetween(1, 100),
            'cliid' => 430006432,
            'dirnom' => fake()->name(),
            'dirape' => fake()->name(),
            'dirdir' => fake()->address(),
            'dirpob' => 'Madrid',
            'dirpai' => 'España',
            'dircp' => fake()->postcode(),

            'dirtfno1' => fake()->phoneNumber(),
            'dirtfno2' => fake()->phoneNumber(),
        ];
    }
}
