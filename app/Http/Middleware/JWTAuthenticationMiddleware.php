<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $patient = JWTAuth::parseToken()->authenticate();

            if (! $patient) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $request->setUserResolver(function () use ($patient) {
                return $patient;
            });

            return $next($request);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
}
