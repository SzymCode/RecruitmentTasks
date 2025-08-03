<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;

beforeEach(function (): void {
    $this->model = Order::factory()->create();
});

it('can be created', function (): void {
    expect($this->model)->toBeInstanceOf(Order::class);
});

describe('Instance', function (): void {
    test('can get id', function (): void {
        expect($this->model->getId())
            ->toBeInt()
            ->toBe($this->model->id);
    });

    test('can get patient_id', function (): void {
        expect($this->model->getPatientId())
            ->toBeInt()
            ->toBe($this->model->patient_id);
    });

    test('can get created_at', function (): void {
        expect($this->model->getCreatedAt())
            ->toBeString()
            ->toBe($this->model->created_at->toDateTimeString());
    });

    test('can get updated_at', function (): void {
        expect($this->model->getUpdatedAt())
            ->toBeString()
            ->toBe($this->model->updated_at->toDateTimeString());
    });
});

describe('Relationship', function (): void {
    test('can get patient', function (): void {
        expect($this->model->patient)
            ->toBeInstanceOf(Patient::class)
            ->and($this->model->patient->id)
            ->toBe($this->model->patient_id);
    });

    test('can get test_results', function (): void {
        TestResult::factory(3)->create([
            'order_id' => $this->model->id,
        ]);

        foreach ($this->model->testResults as $testResult) {
            expect($testResult)
                ->toBeInstanceOf(TestResult::class)
                ->and($testResult->order_id)
                ->toBe($this->model->id);
        }
    });
});
