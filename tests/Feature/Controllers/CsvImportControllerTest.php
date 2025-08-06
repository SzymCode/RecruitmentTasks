<?php

use App\Http\Controllers\CsvImportController;
use App\Models\Patient;
use App\Services\CsvImportService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

beforeEach(function (): void {
    $this->csvImportService = mock(CsvImportService::class);
    $this->controller = new CsvImportController($this->csvImportService);
    $this->patient = Patient::factory()->create(patientData);
});

describe('200', function (): void {
    test('can import CSV file successfully', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

        $expectedResult = [
            'success' => true,
            'output' => 'Starting CSV import from: /path/to/file.csv\nCSV header validated successfully\nImport completed successfully!\nImported: 100 records\nErrors: 0 records',
            'result_code' => 0,
        ];

        $this->csvImportService->shouldReceive('importFromUploadedFile')
            ->once()
            ->with($file)
            ->andReturn($expectedResult);

        $response = $this->controller->import(new Request([], [], [], [], ['file' => $file]));

        expect($response->getStatusCode())->toEqual(200);
        $data = $response->getData(true);
        expect($data['message'])->toBe('CSV import completed successfully');
        expect($data['output'])->toBe($expectedResult['output']);
    });
});

describe('422', function (): void {
    test('returns error when service validation fails', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

        $expectedResult = [
            'success' => false,
            'output' => 'File validation failed: The file field must be a file.',
            'result_code' => 1,
        ];

        $this->csvImportService->shouldReceive('importFromUploadedFile')
            ->once()
            ->with($file)
            ->andReturn($expectedResult);

        $response = $this->controller->import(new Request([], [], [], [], ['file' => $file]));

        expect($response->getStatusCode())->toEqual(422);
        $data = $response->getData(true);
        expect($data['error'])->toBe('CSV import failed');
        expect($data['output'])->toBe($expectedResult['output']);
    });

    test('returns error when service processing fails', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

        $expectedResult = [
            'success' => false,
            'output' => 'Invalid CSV header. Expected: patientId, patientName, patientSurname, patientSex, patientBirthDate, orderId, testName, testValue, testReference',
            'result_code' => 1,
        ];

        $this->csvImportService->shouldReceive('importFromUploadedFile')
            ->once()
            ->with($file)
            ->andReturn($expectedResult);

        $response = $this->controller->import(new Request([], [], [], [], ['file' => $file]));

        expect($response->getStatusCode())->toEqual(422);
        $data = $response->getData(true);
        expect($data['error'])->toBe('CSV import failed');
        expect($data['output'])->toBe($expectedResult['output']);
    });
});

describe('500', function (): void {
    test('returns error when service throws exception', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

        $this->csvImportService->shouldReceive('importFromUploadedFile')
            ->once()
            ->with($file)
            ->andThrow(new \Exception('Service error'));

        $response = $this->controller->import(new Request([], [], [], [], ['file' => $file]));

        expect($response->getStatusCode())->toEqual(500);
        $data = $response->getData(true);
        expect($data['error'])->toBe('Import failed: Service error');
    });

    test('returns error when file processing fails', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

        $this->csvImportService->shouldReceive('importFromUploadedFile')
            ->once()
            ->with($file)
            ->andThrow(new \RuntimeException('File processing failed'));

        $response = $this->controller->import(new Request([], [], [], [], ['file' => $file]));

        expect($response->getStatusCode())->toEqual(500);
        $data = $response->getData(true);
        expect($data['error'])->toBe('Import failed: File processing failed');
    });
});
