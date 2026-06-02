<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vaccine_name' => $this->faker->name(),
            'vaccine_description' => $this->faker->paragraph(),
        ];
    }
}
