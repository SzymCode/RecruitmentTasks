<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;

beforeEach(function (): void {
    $this->patient = Patient::factory()->create(patientData);
    $this->credentials = [
        'login' => $this->patient->getName().$this->patient->getSurname(),
        'password' => $this->patient->getBirthDate(),
    ];

    $this->order = Order::factory()->create([
        'patient_id' => $this->patient->getId(),
    ]);

    TestResult::factory()->create([
        'order_id' => $this->order->getId(),
    ]);
});

describe('200', function (): void {
    test('can login and get JWT token', function (): void {
        $response = $this->postJson('/api/login', $this->credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    });

    test('can access protected endpoint with valid token', function (): void {
        $response = withPatientToken($this->patient)->getJson('/api/test-results');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'patient' => [
                    'id',
                    'name',
                    'surname',
                    'sex',
                    'birthDate',
                ],
                'orders' => [
                    '*' => [
                        'orderId',
                        'results' => [
                            '*' => [
                                'name',
                                'value',
                                'reference',
                            ],
                        ],
                    ],
                ],
            ]);
    });

    test('can logout with valid token', function (): void {
        $response = withPatientToken($this->patient)->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    });

    test('can get current user info', function (): void {
        $response = withPatientToken($this->patient)->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $this->patient->getId(),
                'name' => $this->patient->getName(),
                'surname' => $this->patient->getSurname(),
            ]);
    });
});
