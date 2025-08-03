<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Patient;

class TestResultsService
{
    public function getPatientResults(int $patientId): array
    {
        $patient = Patient::findOrFail($patientId);

        $orders = Order::with(['testResults'])
            ->where('patient_id', $patientId)
            ->get();

        $formattedOrders = $orders->map(function ($order) {
            return [
                'orderId' => (string) $order->id,
                'results' => $order->testResults->map(function ($testResult) {
                    return [
                        'name' => $testResult->test_name,
                        'value' => (string) $testResult->test_value,
                        'reference' => $testResult->test_reference,
                    ];
                })->toArray(),
            ];
        })->toArray();

        return [
            'patient' => [
                'id' => $patient->id,
                'name' => $patient->name,
                'surname' => $patient->surname,
                'sex' => $patient->sex,
                'birthDate' => $patient->birth_date->format('Y-m-d'),
            ],
            'orders' => $formattedOrders,
        ];
    }
}
