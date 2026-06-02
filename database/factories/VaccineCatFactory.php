<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineCatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cat = Cat::all()->random(1)->last();
        $vaccine = Vaccine::all()->random(1)->first();
        return [
            'cat_id' => $cat->id,
            'vaccine_id' => $vaccine->id,
        ];
    }
}
