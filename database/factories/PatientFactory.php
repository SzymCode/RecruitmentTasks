<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Validator;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        $data = [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'sex' => $this->faker->randomElement(['m', 'f']),
            'birth_date' => $this->faker->dateTimeBetween('-100 years', '-10 years')->format('Y-m-d'),
        ];

        Validator::make($data, [
            'name' => 'required|string|min:3|max:255',
            'surname' => 'required|string|min:3|max:255',
            'sex' => 'required|string|min:1|max:1',
            'birth_date' => 'required|date',
        ]);

        return $data;
    }
}
