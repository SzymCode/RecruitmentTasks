<?php

use App\Models\Patient;

function getPatientToken(Patient $patient): string
{
    $response = test()->postJson('/api/login', [
        'login' => $patient->name.$patient->surname,
        'password' => $patient->birth_date->format('Y-m-d'),
    ]);

    return $response->json('token');
}

function withPatientToken(Patient $patient)
{
    return test()->withHeaders([
        'Authorization' => 'Bearer '.getPatientToken($patient),
    ]);
}
