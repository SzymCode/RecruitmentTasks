<?php

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('local');
    Log::spy();
});

describe('import:csv command', function (): void {
    describe('successful imports', function (): void {
        test('can import valid CSV data successfully', function (): void {
            $testData = generateTestData(1);
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Starting CSV import from: '.$tempFile)
                ->expectsOutput('CSV header validated successfully')
                ->expectsOutput('Import completed successfully!')
                ->expectsOutput('Imported: 1 records')
                ->expectsOutput('Errors: 0 records');

            expect(Patient::count())->toBe(1);
            expect(Order::count())->toBe(1);
            expect(TestResult::count())->toBe(1);

            $patient = Patient::first();
            expect($patient->name)->toBe($testData[0]['patientName']);
            expect($patient->surname)->toBe($testData[0]['patientSurname']);
            expect($patient->sex)->toBe($testData[0]['patientSex']);
            expect($patient->birth_date->format('Y-m-d'))->toBe($testData[0]['patientBirthDate']);

            $testResult = TestResult::first();
            expect($testResult->test_name)->toBe($testData[0]['testName']);
            expect($testResult->test_value)->toBe($testData[0]['testValue']);
            expect($testResult->test_reference)->toBe($testData[0]['testReference']);

            cleanupTempFile($tempFile);
        });

        test('can import multiple valid records', function (): void {
            $testData = generateTestData(3);
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 3 records')
                ->expectsOutput('Errors: 0 records');

            expect(Patient::count())->toBe(3);
            expect(Order::count())->toBe(3);
            expect(TestResult::count())->toBe(3);

            cleanupTempFile($tempFile);
        });

        test('can import empty rows gracefully', function (): void {
            $headers = [
                'patientId', 'patientName', 'patientSurname', 'patientSex',
                'patientBirthDate', 'orderId', 'testName', 'testValue', 'testReference',
            ];
            $csvContent = implode(';', $headers)."\n";
            $csvContent .= "\n";
            $csvContent .= "1;John;Smith;m;1990-05-15;1;Blood Glucose;95;70-100\n";
            $csvContent .= "\n";
            $csvContent .= "2;Jane;Doe;f;1985-08-22;2;Hemoglobin;14.2;12-16\n";

            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 2 records')
                ->expectsOutput('Errors: 0 records');

            expect(Patient::count())->toBe(2);
            expect(Order::count())->toBe(2);
            expect(TestResult::count())->toBe(2);

            cleanupTempFile($tempFile);
        });

        test('can import empty CSV file with only headers', function (): void {
            $headers = [
                'patientId', 'patientName', 'patientSurname', 'patientSex',
                'patientBirthDate', 'orderId', 'testName', 'testValue', 'testReference',
            ];
            $csvContent = implode(';', $headers)."\n";

            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 0 records');

            expect(Patient::count())->toBe(0);
            expect(Order::count())->toBe(0);
            expect(TestResult::count())->toBe(0);

            cleanupTempFile($tempFile);
        });

        test('can normalize sex correctly', function (): void {
            $testData = [
                [
                    'patientId' => 1,
                    'patientName' => 'John',
                    'patientSurname' => 'Smith',
                    'patientSex' => 'male',
                    'patientBirthDate' => '1990-05-15',
                    'orderId' => 1,
                    'testName' => 'Blood Glucose',
                    'testValue' => '95',
                    'testReference' => '70-100',
                ],
                [
                    'patientId' => 2,
                    'patientName' => 'Jane',
                    'patientSurname' => 'Doe',
                    'patientSex' => 'female',
                    'patientBirthDate' => '1985-08-22',
                    'orderId' => 2,
                    'testName' => 'Hemoglobin',
                    'testValue' => '14.2',
                    'testReference' => '12-16',
                ],
            ];

            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 2 records')
                ->expectsOutput('Errors: 0 records');

            expect(Patient::count())->toBe(2);
            expect(Order::count())->toBe(2);
            expect(TestResult::count())->toBe(2);

            $malePatient = Patient::where('name', 'John')->first();
            expect($malePatient->sex)->toBe('m');

            $femalePatient = Patient::where('name', 'Jane')->first();
            expect($femalePatient->sex)->toBe('f');

            cleanupTempFile($tempFile);
        });
    });

    describe('file validation errors', function (): void {
        test('can handle missing file', function (): void {
            $nonExistentFile = 'nonexistent_file_'.uniqid().'.csv';

            $this->artisan('import:csv', ['file' => $nonExistentFile])
                ->assertExitCode(1)
                ->expectsOutput("File not found or not readable: {$nonExistentFile}");
        });

        test('can handle unreadable file', function (): void {
            $tempFile = createTempFile('test content');
            chmod($tempFile, 0000);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput("File not found or not readable: {$tempFile}");

            chmod($tempFile, 0644);
            cleanupTempFile($tempFile);
        });

        test('can handle fopen failure', function (): void {
            $tempFile = createTempFile('test content');
            chmod($tempFile, 0000);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput("File not found or not readable: {$tempFile}");

            chmod($tempFile, 0644);
            cleanupTempFile($tempFile);
        });

        test('can handle database rollback exception', function (): void {
            $malformedCsv = "patientId;patientName;patientSurname;patientSex;patientBirthDate;orderId;testName;testValue;testReference\n";
            $malformedCsv .= "1;John;Smith;m;1990-05-15;1;Blood Glucose;95\n";

            $tempFile = createTempFile($malformedCsv);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle array_combine failure', function (): void {
            $malformedCsv = "patientId;patientName;patientSurname;patientSex;patientBirthDate;orderId;testName;testValue;testReference\n";
            $malformedCsv .= "1;John;Smith;m;1990-05-15;1;Blood Glucose;95;70-100;extra_column\n";

            $tempFile = createTempFile($malformedCsv);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle database exception during processing', function (): void {
            $testData = generateInvalidTestData(1, 'long_patient_name');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle mixed success and failure scenarios', function (): void {
            $validData = generateTestData(2);
            $invalidData = generateInvalidTestData(2, 'mixed_errors');
            $allData = array_merge($validData, $invalidData);

            $csvContent = createCsvContent($allData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 2 records')
                ->expectsOutput('Errors: 2 records');

            expect(Patient::count())->toBe(2);
            expect(Order::count())->toBe(2);
            expect(TestResult::count())->toBe(2);

            cleanupTempFile($tempFile);
        });

        test('can handle exception during processing to trigger finally block', function (): void {
            $malformedCsv = "patientId;patientName;patientSurname;patientSex;patientBirthDate;orderId;testName;testValue;testReference\n";
            $malformedCsv .= "1;John;Smith;m;1990-05-15;1;Blood Glucose;95\n";

            $tempFile = createTempFile($malformedCsv);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle processRow database exception', function (): void {
            $testData = generateInvalidTestData(1, 'long_test_name');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });
    });

    describe('CSV validation errors', function (): void {
        test('can handle invalid CSV header', function (): void {
            $invalidHeaders = ['wrong', 'header', 'format'];
            $csvContent = implode(';', $invalidHeaders)."\n";
            $csvContent .= "1;John;Smith\n";

            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput('Import failed: Invalid CSV header');

            cleanupTempFile($tempFile);
        });

        test('can handle empty header', function (): void {
            $tempFile = createTempFile('');

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput('Import failed: Invalid CSV header');

            cleanupTempFile($tempFile);
        });

        test('can handle malformed CSV content', function (): void {
            $tempFile = createTempFile("invalid\ncsv\ncontent\nwith\nno\ncommas");

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput('Import failed: Invalid CSV header');

            cleanupTempFile($tempFile);
        });

        test('can handle header with wrong number of columns', function (): void {
            $invalidHeaders = ['patientId', 'patientName', 'patientSurname'];
            $csvContent = implode(';', $invalidHeaders)."\n";
            $csvContent .= "1;John;Smith\n";

            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput('Import failed: Invalid CSV header');

            cleanupTempFile($tempFile);
        });

        test('can handle header with wrong column names', function (): void {
            $invalidHeaders = [
                'patientId', 'patientName', 'patientSurname', 'patientSex',
                'patientBirthDate', 'orderId', 'testName', 'testValue', 'wrongColumn',
            ];
            $csvContent = implode(';', $invalidHeaders)."\n";
            $csvContent .= "1;John;Smith;m;1990-05-15;1;Blood Glucose;95;70-100\n";

            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput('Import failed: Invalid CSV header');

            cleanupTempFile($tempFile);
        });

        test('can handle null header', function (): void {
            $tempFile = createTempFile("\0\0\0");

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(1)
                ->expectsOutput('Import failed: Invalid CSV header');

            cleanupTempFile($tempFile);
        });
    });

    describe('data validation errors', function (): void {
        test('can handle validation failures in processRow', function (): void {
            $testData = generateInvalidTestData(1, 'invalid_patient_id');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle invalid patient sex', function (): void {
            $testData = generateInvalidTestData(1, 'invalid_sex');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle invalid date format', function (): void {
            $testData = generateInvalidTestData(1, 'invalid_date');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle multiple validation errors', function (): void {
            $testData = generateInvalidTestData(3, 'mixed_errors');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 3 records');

            cleanupTempFile($tempFile);
        });
    });

    describe('database errors', function (): void {
        test('can handle database constraint violations gracefully', function (): void {
            $testData = generateInvalidTestData(1, 'long_field');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can continue processing after individual row failures', function (): void {
            $validData = generateTestData(1);
            $invalidData = generateInvalidTestData(1, 'long_field');
            $allData = array_merge($validData, $invalidData);

            $csvContent = createCsvContent($allData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 1 records')
                ->expectsOutput('Errors: 1 records');

            expect(Patient::count())->toBe(1);
            expect(Order::count())->toBe(1);
            expect(TestResult::count())->toBe(1);

            cleanupTempFile($tempFile);
        });

        test('can handle processRow exception', function (): void {
            $testData = generateInvalidTestData(1, 'long_test_name');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle processRow exception with database error', function (): void {
            $testData = generateInvalidTestData(1, 'long_patient_name');
            $csvContent = createCsvContent($testData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 0 records')
                ->expectsOutput('Errors: 1 records');

            cleanupTempFile($tempFile);
        });

        test('can handle mixed success and failure scenarios', function (): void {
            $validData = generateTestData(2);
            $invalidData = generateInvalidTestData(2, 'mixed_errors');
            $allData = array_merge($validData, $invalidData);

            $csvContent = createCsvContent($allData);
            $tempFile = createTempFile($csvContent);

            $this->artisan('import:csv', ['file' => $tempFile])
                ->assertExitCode(0)
                ->expectsOutput('Imported: 2 records')
                ->expectsOutput('Errors: 2 records');

            expect(Patient::count())->toBe(2);
            expect(Order::count())->toBe(2);
            expect(TestResult::count())->toBe(2);

            cleanupTempFile($tempFile);
        });
    });
});

// Helper methods
function generateTestData(int $count): array
{
    $data = [];
    $names = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emma', 'James', 'Olivia', 'Robert', 'Sophia'];
    $surnames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
    $testNames = ['Blood Glucose', 'Hemoglobin', 'Cholesterol', 'Triglycerides', 'HDL', 'LDL', 'Creatinine', 'Urea', 'Sodium', 'Potassium'];

    for ($i = 0; $i < $count; $i++) {
        $data[] = [
            'patientId' => $i + 1,
            'patientName' => $names[$i % count($names)],
            'patientSurname' => $surnames[$i % count($surnames)],
            'patientSex' => $i % 2 === 0 ? 'm' : 'f',
            'patientBirthDate' => '199'.($i % 10).'-0'.(($i % 9) + 1).'-0'.(($i % 9) + 1),
            'orderId' => $i + 1,
            'testName' => $testNames[$i % count($testNames)],
            'testValue' => (string) (80 + $i * 5),
            'testReference' => (70 + $i * 5).'-'.(100 + $i * 5),
        ];
    }

    return $data;
}

function generateInvalidTestData(int $count, string $errorType): array
{
    $data = [];

    for ($i = 0; $i < $count; $i++) {
        $baseData = [
            'patientId' => $i + 1,
            'patientName' => 'John',
            'patientSurname' => 'Smith',
            'patientSex' => 'm',
            'patientBirthDate' => '1990-05-15',
            'orderId' => $i + 1,
            'testName' => 'Blood Glucose',
            'testValue' => '95',
            'testReference' => '70-100',
        ];

        switch ($errorType) {
            case 'invalid_patient_id':
                $baseData['patientId'] = 'invalid';
                break;
            case 'invalid_sex':
                $baseData['patientSex'] = 'x';
                break;
            case 'invalid_date':
                $baseData['patientBirthDate'] = '1990/05/15';
                break;
            case 'long_field':
                $baseData['testName'] = str_repeat('A', 1000);
                break;
            case 'long_test_name':
                $baseData['testName'] = str_repeat('A', 1000);
                break;
            case 'long_patient_name':
                $baseData['patientName'] = str_repeat('A', 1000);
                break;
            case 'mixed_errors':
                if ($i % 3 === 0) {
                    $baseData['patientId'] = 'invalid';
                } elseif ($i % 3 === 1) {
                    $baseData['patientSex'] = 'x';
                } else {
                    $baseData['patientBirthDate'] = '1990/05/15';
                }
                break;
        }

        $data[] = $baseData;
    }

    return $data;
}

function createCsvContent(array $data): string
{
    $headers = [
        'patientId', 'patientName', 'patientSurname', 'patientSex',
        'patientBirthDate', 'orderId', 'testName', 'testValue', 'testReference',
    ];
    $csvContent = implode(';', $headers)."\n";

    foreach ($data as $row) {
        $csvContent .= implode(';', array_values($row))."\n";
    }

    return $csvContent;
}

function createTempFile(string $content): string
{
    $tempFile = tempnam(sys_get_temp_dir(), 'test_csv_');
    file_put_contents($tempFile, $content);

    return $tempFile;
}

function cleanupTempFile(string $filePath): void
{
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}
