<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\TestResultResource;
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
            $orderData = (new OrderResource($order))->resolve();

            return array_merge($orderData, [
                'results' => $order->testResults->map(function ($testResult) {
                    return (new TestResultResource($testResult))->resolve();
                })->toArray(),
            ]);
        })->toArray();

        return [
            'patient' => (new PatientResource($patient))->resolve(),
            'orders' => $formattedOrders,
        ];
    }
}
