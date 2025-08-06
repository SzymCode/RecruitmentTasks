<?php

namespace App\Http\Controllers;

use App\Services\CsvImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CsvImportController extends Controller
{
    public function __construct(
        private CsvImportService $csvImportService
    ) {}

    public function import(Request $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $result = $this->csvImportService->importFromUploadedFile($file);

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
