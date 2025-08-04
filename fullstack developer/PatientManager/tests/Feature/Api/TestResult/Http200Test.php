<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;

beforeEach(function (): void {
    $patient = Patient::factory()->create([
        'name' => 'Szymon',
        'surname' => 'Radomski',
        'sex' => 'M',
        'birth_date' => '1970-01-01',
    ]);

    $order = Order::factory()->create([
        'patient_id' => $patient->id,
    ]);

    TestResult::factory(2)->create([
        'order_id' => $order->id,
    ]);
});

describe('200', function (): void {
    test('can get test results', function (): void {
        $response = $this->getJson('/api/test-results');

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
