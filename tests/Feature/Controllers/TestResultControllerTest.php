<?php

use App\Http\Controllers\TestResultsController;
use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;
use App\Services\TestResultsService;
use Illuminate\Http\Request;

beforeEach(function (): void {
    $this->controller = app()->makeWith(TestResultsController::class, ['testResultsService' => app()->make(TestResultsService::class)]);
});

describe('200', function (): void {
    it('success if patient data and test results exist', function (): void {
        $patient = Patient::factory()->create();
        $order = Order::factory()->create(['patient_id' => $patient->id]);
        TestResult::factory()->create(['order_id' => $order->id]);

        $response = $this->controller->index(new Request);

        expect($response->getStatusCode())->toEqual(200);

        $data = $response->getData(true);

        expect($data)->toHaveKeys(['patient', 'orders']);
        expect($data['patient']['id'])->toBe($patient->id);
        expect($data['orders'])->toHaveCount(1);
    });
});

describe('404', function (): void {
    it('fails if no patients exist', function (): void {
        Patient::query()->delete();

        $response = $this->controller->index(new Request);

        expect($response->getStatusCode())->toEqual(404);
        expect($response->getData(true)['error'])->toBe('No patients found');
    });
});

describe('500', function (): void {
    it('fails if service throws exception', function (): void {
        Patient::factory()->create();

        $mockService = Mockery::mock(TestResultsService::class);
        $mockService->shouldReceive('getPatientResults')->once()->andThrow(new Exception);

        $controller = app()->makeWith(TestResultsController::class, ['testResultsService' => $mockService]);

        $response = $controller->index(new Request);

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Failed to retrieve results');
    });
});
