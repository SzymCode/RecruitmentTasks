<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportCsvCommand extends Command
{
    protected $signature = 'import:csv {file : Path to the CSV file}';

    protected $description = 'Import patients, orders, and test results from CSV file';

    private const HEADERS = [
        'patientId', 'patientName', 'patientSurname', 'patientSex',
        'patientBirthDate', 'orderId', 'testName', 'testValue', 'testReference',
    ];

    private const RULES = [
        'patientId' => 'required|integer|min:1',
        'patientName' => 'required|string|max:255',
        'patientSurname' => 'required|string|max:255',
        'patientSex' => 'required|in:m,f,male,female',
        'patientBirthDate' => 'required|date_format:Y-m-d',
        'orderId' => 'required|integer|min:1',
        'testName' => 'required|string|max:255',
        'testValue' => 'required|string|max:255',
        'testReference' => 'nullable|string|max:255',
    ];

    public function handle(): int
    {
        $filePath = $this->argument('file');

        if (! file_exists($filePath) || ! is_readable($filePath)) {
            $this->error("File not found or not readable: {$filePath}");

            return Command::FAILURE;
        }

        $this->info("Starting CSV import from: {$filePath}");

        try {
            $stats = $this->processImport($filePath);
            $this->displayResults($stats);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Import failed: {$e->getMessage()}");

            return Command::FAILURE;
        }
    }

    private function processImport(string $filePath): array
    {
        $handle = fopen($filePath, 'r');

        $header = fgetcsv($handle, 0, ';');
        if (! $this->validateHeader($header)) {
            fclose($handle);
            throw new \RuntimeException('Invalid CSV header');
        }

        $stats = ['imported' => 0, 'errors' => 0];

        DB::beginTransaction();
        $lineNumber = 0;
        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $lineNumber++;
            if (! empty(array_filter($row))) {
                try {
                    $data = array_combine($header, $row);
                    $this->processRow($data, $lineNumber) ? $stats['imported']++ : $stats['errors']++;
                } catch (\ValueError $e) {
                    $this->warn("Line {$lineNumber}: Invalid data format");
                    $stats['errors']++;
                }
            }
        }
        DB::commit();

        fclose($handle);

        return $stats;
    }

    private function validateHeader($header): bool
    {
        if (! $header || ! is_array($header) || count($header) !== count(self::HEADERS) || array_diff(self::HEADERS, $header)) {
            $this->error('Invalid CSV header. Expected: '.implode(', ', self::HEADERS));

            return false;
        }
        $this->info('CSV header validated successfully');

        return true;
    }

    private function processRow(array $data, int $lineNumber): bool
    {
        if (isset($data['patientSex'])) {
            $data['patientSex'] = $this->normalizeSex($data['patientSex']);
        }

        if (Validator::make($data, self::RULES)->fails()) {
            $this->warn("Line {$lineNumber}: Validation failed");

            return false;
        }

        $patient = Patient::firstOrCreate([
            'name' => $data['patientName'],
            'surname' => $data['patientSurname'],
            'sex' => $data['patientSex'],
            'birth_date' => $data['patientBirthDate'],
        ]);

        $order = Order::firstOrCreate(['patient_id' => $patient->id]);

        TestResult::create([
            'order_id' => $order->id,
            'test_name' => $data['testName'],
            'test_value' => $data['testValue'],
            'test_reference' => $data['testReference'] ?: null,
        ]);

        return true;
    }

    private function normalizeSex(string $sex): string
    {
        return match (strtolower(trim($sex))) {
            'male' => 'm',
            'female' => 'f',
            default => $sex
        };
    }

    private function displayResults(array $stats): void
    {
        $this->info('Import completed successfully!');
        $this->info("Imported: {$stats['imported']} records");
        $this->info("Errors: {$stats['errors']} records");
    }
}
