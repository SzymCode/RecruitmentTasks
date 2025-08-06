<?php

use App\Services\ImportCsvService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    $this->service = app()->make(ImportCsvService::class);
    Storage::fake('local');
});

describe('200', function (): void {
    test('can validate CSV file successfully', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

        $result = $this->service->importFromUploadedFile($file);

        expect($result)->toHaveKeys(['success', 'output', 'result_code']);
        expect($result['success'])->toBeBool();
        expect($result['output'])->toBeString();
        expect($result['result_code'])->toBeInt();
    });

    test('can reject non-CSV file', function (): void {
        $file = UploadedFile::fake()->create('test.txt', 100, 'text/plain');

        $result = $this->service->importFromUploadedFile($file);

        expect($result['success'])->toBeFalse();
        expect($result['output'])->toContain('Invalid CSV header');
        expect($result['result_code'])->toBe(1);
    });

    test('can reject file larger than 10MB', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 11000, 'text/csv');

        $result = $this->service->importFromUploadedFile($file);

        expect($result['success'])->toBeFalse();
        expect($result['output'])->toContain('The file field must not be greater than 10240 kilobytes');
        expect($result['result_code'])->toBe(1);
    });

    test('can reject empty file', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 0, 'text/csv');

        $result = $this->service->importFromUploadedFile($file);

        expect($result['success'])->toBeFalse();
        expect($result['output'])->toContain('Invalid CSV header');
        expect($result['result_code'])->toBe(1);
    });

    test('can reject file with wrong MIME type', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 100, 'application/pdf');

        $result = $this->service->importFromUploadedFile($file);

        expect($result['success'])->toBeFalse();
        expect($result['output'])->toContain('File validation failed');
        expect($result['result_code'])->toBe(1);
    });

    test('can handle file with special characters in name', function (): void {
        $file = UploadedFile::fake()->create('test-file_123.csv', 100, 'text/csv');

        $result = $this->service->importFromUploadedFile($file);

        expect($result)->toHaveKeys(['success', 'output', 'result_code']);
    });

    test('can handle file with spaces in name', function (): void {
        $file = UploadedFile::fake()->create('test file.csv', 100, 'text/csv');

        $result = $this->service->importFromUploadedFile($file);

        expect($result)->toHaveKeys(['success', 'output', 'result_code']);
    });

    test('can handle very small file', function (): void {
        $file = UploadedFile::fake()->create('test.csv', 1, 'text/csv');

        $result = $this->service->importFromUploadedFile($file);

        expect($result)->toHaveKeys(['success', 'output', 'result_code']);
    });
});
