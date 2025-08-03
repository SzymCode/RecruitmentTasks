<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Validator;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            $patient = Patient::factory()->create();
            $patientId = $patient->id;
        } else {
            $patientId = $this->faker->randomElement($patients->pluck('id')->toArray());
        }

        $data = [
            'patient_id' => $patientId,
        ];

        Validator::make($data, [
            'patient_id' => 'required|integer|exists:patients,id',
        ]);

        return $data;
    }
}
