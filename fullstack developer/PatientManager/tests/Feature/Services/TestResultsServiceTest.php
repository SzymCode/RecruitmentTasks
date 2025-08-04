<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;
use App\Services\TestResultsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function (): void {
    $this->service = app()->make(TestResultsService::class);
    $this->patient = Patient::factory()->create(patientData);
});

describe('200', function (): void {
    test('can get patient results with orders and test results', function (): void {
        $order = Order::factory()->create(['patient_id' => $this->patient->getId()]);
        $testResult = TestResult::factory()->create();

        $result = $this->service->getPatientResults($this->patient->getId());

        expect($result)->toHaveKeys(['patient', 'orders']);
        expect($result['patient']['id'])->toBe($this->patient->getId());
        expect($result['patient']['name'])->toBe($this->patient->getName());
        expect($result['patient']['surname'])->toBe($this->patient->getSurname());
        expect($result['patient']['sex'])->toBe($this->patient->getSex());
        expect($result['patient']['birthDate'])->toBe($this->patient->getBirthDate());

        expect($result['orders'])->toHaveCount(1);
        expect($result['orders'][0]['orderId'])->toBe((string) $order->getId());
        expect($result['orders'][0]['results'])->toHaveCount(1);
        expect($result['orders'][0]['results'][0]['name'])->toBe($testResult->getTestName());
        expect($result['orders'][0]['results'][0]['value'])->toBe($testResult->getTestValue());
        expect($result['orders'][0]['results'][0]['reference'])->toBe($testResult->getTestReference());
    });

    test('can get patient results with multiple orders', function (): void {
        $order1 = Order::factory()->create(['patient_id' => $this->patient->getId()]);
        $order2 = Order::factory()->create(['patient_id' => $this->patient->getId()]);

        TestResult::factory()->create(['order_id' => $order1->getId()]);
        TestResult::factory()->create(['order_id' => $order2->getId()]);

        $result = $this->service->getPatientResults($this->patient->getId());

        expect($result['orders'])->toHaveCount(2);
        expect($result['orders'][0]['orderId'])->toBe((string) $order1->getId());
        expect($result['orders'][1]['orderId'])->toBe((string) $order2->getId());
    });

    test('can get patient results with no orders', function (): void {
        $result = $this->service->getPatientResults($this->patient->getId());

        expect($result['patient']['id'])->toBe($this->patient->getId());
        expect($result['orders'])->toHaveCount(0);
    });

    test('can get patient results with order but no test results', function (): void {
        $order = Order::factory()->create(['patient_id' => $this->patient->getId()]);

        $result = $this->service->getPatientResults($this->patient->getId());

        expect($result['orders'])->toHaveCount(1);
        expect($result['orders'][0]['orderId'])->toBe((string) $order->getId());
        expect($result['orders'][0]['results'])->toHaveCount(0);
    });

    test('can get patient results with decimal test values', function (): void {
        $order = Order::factory()->create(['patient_id' => $this->patient->getId()]);
        $testResult = TestResult::factory()->create();

        $result = $this->service->getPatientResults($this->patient->getId());

        expect($result['orders'][0]['results'][0]['value'])->toBe($testResult->getTestValue());
    });

    test('can get patient results with zero test values', function (): void {
        $order = Order::factory()->create(['patient_id' => $this->patient->getId()]);
        $testResult = TestResult::factory()->create();

        $result = $this->service->getPatientResults($this->patient->getId());

        expect($result['orders'][0]['results'][0]['value'])->toBe($testResult->getTestValue());
    });
});

describe('404', function (): void {
    test('can\'t get patient results when patient not found', function (): void {
        expect(fn () => $this->service->getPatientResults(999))
            ->toThrow(ModelNotFoundException::class);
    });

    test('can\'t get patient results when patient id is invalid', function (): void {
        expect(fn () => $this->service->getPatientResults(0))
            ->toThrow(ModelNotFoundException::class);
    });
});
