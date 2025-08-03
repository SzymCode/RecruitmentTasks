<?php

use App\Models\Order;
use App\Models\Patient;

beforeEach(function (): void {
    $this->model = Patient::factory()->create();
});

it('can be created', function (): void {
    expect($this->model)->toBeInstanceOf(Patient::class);
});

describe('Instance', function (): void {
    test('can get id', function (): void {
        expect($this->model->getId())
            ->toBeInt()
            ->toBe($this->model->id);
    });

    test('can get name', function (): void {
        expect($this->model->getName())
            ->toBeString()
            ->toBe($this->model->name);
    });

    test('can get surname', function (): void {
        expect($this->model->getSurname())
            ->toBeString()
            ->toBe($this->model->surname);
    });

    test('can get sex', function (): void {
        expect($this->model->getSex())
            ->toBeString()
            ->toBe($this->model->sex);
    });

    test('can get birth_date', function (): void {
        expect($this->model->getBirthDate())
            ->toBeString()
            ->toBe($this->model->birth_date->toDateTimeString());
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
    test('can get orders', function (): void {
        Order::factory(3)->create([
            'patient_id' => $this->model->id,
        ]);

        foreach ($this->model->orders as $order) {
            expect($order)
                ->toBeInstanceOf(Order::class)
                ->and($order->patient_id)
                ->toBe($this->model->id);
        }
    });
});
