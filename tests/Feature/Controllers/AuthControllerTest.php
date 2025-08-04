<?php

use App\Http\Controllers\AuthController;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\AuthService;
use Illuminate\Http\Request;

beforeEach(function (): void {
    $this->authService = mock(AuthService::class);
    $this->controller = new AuthController($this->authService);
    $this->patient = Patient::factory()->create(patientData);
});

describe('200', function (): void {
    test('can login and get JWT token', function (): void {
        $request = new Request([
            'login' => $this->patient->getName().$this->patient->getSurname(),
            'password' => $this->patient->getBirthDate(),
        ]);

        $expectedResponse = response()->json(['token' => 'test-token']);

        $this->authService->shouldReceive('login')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        $response = $this->controller->login($request);

        expect($response->getStatusCode())->toEqual(200);
        $data = $response->getData(true);
        expect($data)->toHaveKey('token');
        expect($data['token'])->toBe('test-token');
    });

    test('can get authenticated patient data', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => $this->patient);

        $expectedResponse = response()->json(new PatientResource($this->patient));

        $this->authService->shouldReceive('me')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        $response = $this->controller->me($request);

        expect($response->getStatusCode())->toEqual(200);
        $data = $response->getData(true);

        expect($data['id'])->toBe($this->patient->getId());
        expect($data['name'])->toBe($this->patient->getName());
        expect($data['surname'])->toBe($this->patient->getSurname());
        expect($data['sex'])->toBe($this->patient->getSex());
        expect($data['birthDate'])->toBe($this->patient->getBirthDate());
    });

    test('can logout', function (): void {
        $expectedResponse = response()->json(['message' => 'Successfully logged out']);

        $this->authService->shouldReceive('logout')
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->logout();

        expect($response->getStatusCode())->toEqual(200);
        expect($response->getData(true)['message'])->toBe('Successfully logged out');
    });
});

describe('401', function (): void {
    test('can\'t login with invalid credentials', function (): void {
        $request = new Request([
            'login' => 'Invalid Login',
            'password' => 'wrong-password',
        ]);

        $expectedResponse = response()->json(['error' => 'Invalid credentials'], 401);

        $this->authService->shouldReceive('login')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        $response = $this->controller->login($request);

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Invalid credentials');
    });

    test('can\'t get authenticated patient data when unauthorized', function (): void {
        $request = new Request;

        $expectedResponse = response()->json(['error' => 'Unauthenticated'], 401);

        $this->authService->shouldReceive('me')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        $response = $this->controller->me($request);

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Unauthenticated');
    });
});

describe('422', function (): void {
    test('can\'t login with validation errors', function (): void {
        $request = new Request([
            'login' => $this->patient->getName().$this->patient->getSurname(),
        ]);

        $expectedResponse = response()->json([
            'error' => 'Validation failed',
            'messages' => ['password' => ['The password field is required.']],
        ], 422);

        $this->authService->shouldReceive('login')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        $response = $this->controller->login($request);

        expect($response->getStatusCode())->toEqual(422);
        $data = $response->getData(true);
        expect($data)->toHaveKey('error');
        expect($data)->toHaveKey('messages');
    });
});

describe('500', function (): void {
    test('can\'t login when service throws exception', function (): void {
        $request = new Request([
            'login' => $this->patient->getName().$this->patient->getSurname(),
            'password' => $this->patient->getBirthDate(),
        ]);

        $this->authService->shouldReceive('login')
            ->once()
            ->with($request)
            ->andThrow(new \Exception('Service error'));

        $response = $this->controller->login($request);

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Service error');
    });

    test('can\'t logout when service throws exception', function (): void {
        $this->authService->shouldReceive('logout')
            ->once()
            ->andThrow(new \Exception('Logout error'));

        $response = $this->controller->logout();

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Logout error');
    });

    test('can\'t get authenticated patient data when service throws exception', function (): void {
        $request = new Request;

        $this->authService->shouldReceive('me')
            ->once()
            ->with($request)
            ->andThrow(new \Exception('Me error'));

        $response = $this->controller->me($request);

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Me error');
    });
});
