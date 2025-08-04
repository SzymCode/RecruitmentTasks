<?php

use App\Http\Controllers\TestResultsController;
use App\Models\Patient;
use App\Services\TestResultsService;
use Illuminate\Http\Request;

beforeEach(function (): void {
    $this->testResultsService = mock(TestResultsService::class);
    $this->controller = new TestResultsController($this->testResultsService);
    $this->patient = Patient::factory()->create(patientData);
});

describe('200', function (): void {
    test('can get test results', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => $this->patient);

        $expectedData = [
            'patient' => [
                'id' => $this->patient->getId(),
                'name' => $this->patient->getName(),
                'surname' => $this->patient->getSurname(),
                'sex' => $this->patient->getSex(),
                'birthDate' => $this->patient->getBirthDate(),
            ],
            'orders' => [
                [
                    'orderId' => '1',
                    'results' => [
                        [
                            'name' => 'Blood Test',
                            'value' => '120',
                            'reference' => '100-140',
                        ],
                    ],
                ],
            ],
        ];

        $this->testResultsService->shouldReceive('getPatientResults')
            ->once()
            ->with($this->patient->getId())
            ->andReturn($expectedData);

        $response = $this->controller->index($request);

        expect($response->getStatusCode())->toEqual(200);
        $data = $response->getData(true);
        expect($data)->toHaveKeys(['patient', 'orders']);
        expect($data['patient']['id'])->toBe($this->patient->getId());
        expect($data['orders'])->toHaveCount(1);
        expect($data['orders'][0]['orderId'])->toBe('1');
        expect($data['orders'][0]['results'])->toHaveCount(1);
    });
});

describe('500', function (): void {
    test('can\'t get test results if service throws exception', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => $this->patient);

        $this->testResultsService->shouldReceive('getPatientResults')
            ->once()
            ->with($this->patient->getId())
            ->andThrow(new \Exception('Service error'));

        $response = $this->controller->index($request);

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Failed to retrieve results');
    });

    test('can\'t get test results if patient not found', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => $this->patient);

        $this->testResultsService->shouldReceive('getPatientResults')
            ->once()
            ->with($this->patient->getId())
            ->andThrow(new \Illuminate\Database\Eloquent\ModelNotFoundException);

        $response = $this->controller->index($request);

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Failed to retrieve results');
    });
});
