<?php

namespace App\Http\Controllers;

use App\Services\ImportCsvService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportCsvController extends Controller
{
    public function __construct(
        private ImportCsvService $ImportCsvService
    ) {}

    public function import(Request $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $result = $this->ImportCsvService->importFromUploadedFile($file);

            if ($result['success']) {
                return response()->json([
                    'message' => 'CSV import completed successfully',
                    'output' => $result['output'],
                ], 200);
            } else {
                return response()->json([
                    'error' => 'CSV import failed',
                    'output' => $result['output'],
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Import failed: '.$e->getMessage(),
            ], 500);
        }
    }
}
