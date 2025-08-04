<?php

use App\Http\Middleware\JWTAuthenticationMiddleware;
use App\Models\Patient;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

beforeEach(function (): void {
    $this->middleware = app()->make(JWTAuthenticationMiddleware::class);
    $this->patient = Patient::factory()->create(patientData);
});

describe('200', function (): void {
    test('can authenticate with valid token', function (): void {
        $request = Request::create('/api/test', 'GET');

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andReturn($this->patient);

        $response = $this->middleware->handle($request, function ($request) {
            expect($request->user())->toBe($this->patient);

            return response()->json(['success' => true]);
        });

        expect($response->getStatusCode())->toEqual(200);
        expect($response->getData(true)['success'])->toBe(true);
    });
});

describe('401', function (): void {
    test('can\'t authenticate when no token provided', function (): void {
        $request = Request::create('/api/test', 'GET');

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andThrow(new \Exception('Token not provided'));

        $response = $this->middleware->handle($request, function ($request) {
            return response()->json(['success' => true]);
        });

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Unauthenticated');
    });

    test('can\'t authenticate when token is expired', function (): void {
        $request = Request::create('/api/test', 'GET');

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andThrow(new TokenExpiredException('Token has expired'));

        $response = $this->middleware->handle($request, function ($request) {
            return response()->json(['success' => true]);
        });

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Token expired');
    });

    test('can\'t authenticate when token is invalid', function (): void {
        $request = Request::create('/api/test', 'GET');

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andThrow(new TokenInvalidException('Token is invalid'));

        $response = $this->middleware->handle($request, function ($request) {
            return response()->json(['success' => true]);
        });

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Invalid token');
    });

    test('can\'t authenticate when authenticate returns null', function (): void {
        $request = Request::create('/api/test', 'GET');

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andReturn(null);

        $response = $this->middleware->handle($request, function ($request) {
            return response()->json(['success' => true]);
        });

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Unauthenticated');
    });

    test('can\'t authenticate for other exceptions', function (): void {
        $request = Request::create('/api/test', 'GET');

        JWTAuth::shouldReceive('parseToken->authenticate')
            ->once()
            ->andThrow(new \RuntimeException('Some other error'));

        $response = $this->middleware->handle($request, function ($request) {
            return response()->json(['success' => true]);
        });

        expect($response->getStatusCode())->toEqual(401);
        expect($response->getData(true)['error'])->toBe('Unauthenticated');
    });
});
