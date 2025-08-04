<?php

namespace App\Http\Controllers;

use App\Models\Patient;
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
            $patient = Patient::first();

            if (! $patient) {
                return response()->json([
                    'error' => 'No patients found',
                ], 404);
            }

            $data = $this->testResultsService->getPatientResults($patient->id);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve results',
            ], 500);
        }
    }
}
