<?php

namespace App\Http\Controllers;

use App\Services\TestResultsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestResultsController extends Controller
{
    public function __construct(
        private TestResultsService $testResultsService
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->testResultsService->getPatientResults($request->user()->getId());

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve results',
            ], 500);
        }
    }
}
