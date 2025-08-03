<?php

namespace Database\Seeders;

use App\Models\TestResult;
use Illuminate\Database\Seeder;

class TestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = (env('APP_ENV') === 'production') ? 100 : 40;

        TestResult::factory($count)->create();
    }
}
