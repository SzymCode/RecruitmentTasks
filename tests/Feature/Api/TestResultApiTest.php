<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;

beforeEach(function (): void {
    $this->patient = Patient::factory()->create(patientData);

    $this->order = Order::factory()->create([
        'patient_id' => $this->patient->getId(),
    ]);

    TestResult::factory(2)->create([
        'order_id' => $this->order->getId(),
    ]);
});

describe('200', function (): void {
    test('can get test results', function (): void {
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
});

describe('401', function (): void {
    test('can\'t get test results', function (): void {
        $this->getJson('/api/test-results')
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    });
});
