<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Validator;

class TestResultFactory extends Factory
{
    public function definition(): array
    {
        $orders = Order::all();

        if ($orders->isEmpty()) {
            $order = Order::factory()->create();
            $orderId = $order->id;
        } else {
            $orderId = $this->faker->randomElement($orders->pluck('id')->toArray());
        }

        $data = [
            'order_id' => $orderId,
            'test_name' => $this->faker->randomElement(['blood_test', 'x_ray']),
            'test_value' => $this->faker->numerify('##.##'),
            'test_reference' => $this->faker->numerify('##.##'),
        ];

        Validator::make($data, [
            'order_id' => 'required|integer|exists:orders,id',
            'test_name' => 'required|string|min:3|max:255',
            'test_value' => 'required|string|min:1|max:255',
            'test_reference' => 'nullable|string|max:255',
        ]);

        return $data;
    }
}
