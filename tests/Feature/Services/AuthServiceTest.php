<?php

use App\Models\Patient;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

beforeEach(function (): void {
    $this->service = app()->make(AuthService::class);
    $this->patient = Patient::factory()->create(patientData);
});

describe('200', function (): void {
    test('can login with valid credentials', function (): void {
        $request = new Request([
            'login' => $this->patient->getName().$this->patient->getSurname(),
            'password' => $this->patient->getBirthDate(),
        ]);

        $response = $this->service->login($request);

        expect($response->getStatusCode())->toEqual(200);
        $data = $response->getData(true);
        expect($data)->toHaveKey('token');
        expect($data['token'])->toBeString();
    });

    test('can logout successfully', function (): void {
        JWTAuth::shouldReceive('getToken')
            ->once()
            ->andReturn('test-token');

        JWTAuth::shouldReceive('invalidate')
            ->once()
            ->with('test-token');

        $response = $this->service->logout();

        expect($response->getStatusCode())->toEqual(200);
        expect($response->getData(true)['message'])->toBe('Successfully logged out');
    });

    test('can get authenticated patient data', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => $this->patient);

        $response = $this->service->me($request);

        expect($response->getStatusCode())->toEqual(200);
        $data = $response->getData(true);

        expect($data['id'])->toBe($this->patient->getId());
        expect($data['name'])->toBe($this->patient->getName());
        expect($data['surname'])->toBe($this->patient->getSurname());
        expect($data['sex'])->toBe($this->patient->getSex());
        expect($data['birthDate'])->toBe($this->patient->getBirthDate());
    });
});

describe('401', function (): void {
    test('can\'t login with invalid login', function (): void {
        $request = new Request([
            'login' => 'Invalid Login',
            'password' => $this->patient->getBirthDate(),
        ]);

        $response = $this->service->login($request);

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Invalid credentials');
    });

    test('can\'t login with invalid password', function (): void {
        $request = new Request([
            'login' => $this->patient->getName().$this->patient->getSurname(),
            'password' => '1990-01-01',
        ]);

        $response = $this->service->login($request);

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Invalid credentials');
    });

    test('can\'t get authenticated patient data when no user and JWT returns null', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => null);

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andReturn(null);

        $response = $this->service->me($request);

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Unauthenticated');
    });

    test('can\'t get authenticated patient data when JWT throws exception', function (): void {
        $request = new Request;
        $request->setUserResolver(fn () => null);

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andThrow(new \Exception('Token invalid'));

        $response = $this->service->me($request);

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Unauthenticated');
    });
});

describe('422', function (): void {
    test('can\'t login with missing login', function (): void {
        $request = new Request([
            'password' => $this->patient->getBirthDate(),
        ]);

        $response = $this->service->login($request);

        expect($response->getStatusCode())->toEqual(422);
        $data = $response->getData(true);
        expect($data)->toHaveKey('error');
        expect($data)->toHaveKey('messages');
        expect($data['error'])->toBe('Validation failed');
    });

    test('can\'t login with missing password', function (): void {
        $request = new Request([
            'login' => $this->patient->getName().$this->patient->getSurname(),
        ]);

        $response = $this->service->login($request);

        expect($response->getStatusCode())->toEqual(422);
        $data = $response->getData(true);
        expect($data)->toHaveKey('error');
        expect($data)->toHaveKey('messages');
        expect($data['error'])->toBe('Validation failed');
    });
});

describe('500', function (): void {
    test('can\'t logout when JWT throws exception', function (): void {
        JWTAuth::shouldReceive('getToken')
            ->once()
            ->andThrow(new \Exception('Token error'));

        $response = $this->service->logout();

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Could not log out');
    });

    test('can\'t logout when JWT throws exception on invalidate', function (): void {
        JWTAuth::shouldReceive('getToken')
            ->once()
            ->andReturn('test-token');

        JWTAuth::shouldReceive('invalidate')
            ->once()
            ->with('test-token')
            ->andThrow(new \Exception('Invalidate error'));

        $response = $this->service->logout();

        expect($response->getStatusCode())->toEqual(500);
        expect($response->getData(true)['error'])->toBe('Could not log out');
    });
});
