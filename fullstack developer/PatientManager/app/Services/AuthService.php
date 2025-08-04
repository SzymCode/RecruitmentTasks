<?php

namespace App\Services;

use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors(),
            ], 422);
        }

        $login = $request->input('login');
        $password = $request->input('password');

        $patient = Patient::whereRaw('CONCAT(name, surname) = ?', [$login])->first();

        if (! $patient || $patient->getBirthDate() !== $password) {
            return response()->json([
                'error' => 'Invalid credentials',
            ], 401);
        }

        $token = JWTAuth::fromUser($patient);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not log out'], 500);
        }
    }

    public function me(Request $request): JsonResponse
    {
        try {
            $patient = $request->user();

            if (! $patient) {
                JWTAuth::parseToken()->authenticate();

                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            return response()->json(new PatientResource($patient));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
}
