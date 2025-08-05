<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Patient;
use App\Models\TestResult;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Patient::create([
            'id' => 1,
            'name' => 'John',
            'surname' => 'Smith',
            'sex' => 'm',
            'birth_date' => '2021-01-01',
        ]);

        Order::create([
            'id' => 1,
            'patient_id' => 1,
        ]);

        TestResult::factory(10)->create([
            'order_id' => 1,
        ]);

        $this->call([
            OrderSeeder::class,
            PatientSeeder::class,
            TestResultSeeder::class,
        ]);
    }
}
