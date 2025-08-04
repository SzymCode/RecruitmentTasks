<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;

beforeEach(function (): void {
    $this->model = TestResult::factory()->create();
});

test('can be created', function (): void {
    expect($this->model)->toBeInstanceOf(TestResult::class);
});

describe('Instance', function (): void {
    test('can get id', function (): void {
        expect($this->model->getId())
            ->toBeInt()
            ->toBe($this->model->id);
    });

    test('can get order_id', function (): void {
        expect($this->model->getOrderId())
            ->toBeInt()
            ->toBe($this->model->order_id);
    });

    test('can get test_name', function (): void {
        expect($this->model->getTestName())
            ->toBeString()
            ->toBe($this->model->test_name);
    });

    test('can get test_value', function (): void {
        expect($this->model->getTestValue())
            ->toBeString()
            ->toBe($this->model->test_value);
    });

    test('can get test_reference', function (): void {
        expect($this->model->getTestReference())
            ->toBeString()
            ->toBe($this->model->test_reference);
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
    test('can get order', function (): void {
        expect($this->model->order)
            ->toBeInstanceOf(Order::class)
            ->and($this->model->order->id)
            ->toBe($this->model->order_id);
    });

    test('can get patient', function (): void {
        expect($this->model->patient)
            ->toBeInstanceOf(Patient::class)
            ->and($this->model->patient->id)
            ->toBe($this->model->order->patient_id);
    });
});
