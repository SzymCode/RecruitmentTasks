<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FizzBuzzCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fizzbuzz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        Displays numbers from 1 to 100, replacing multiples of 3 with "Fizz", multiples of 5 with "Buzz", and multiples of both with "FizzBuzz".
    ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 1; $i <= 100; $i++) {
            if ($i % 15 === 0) {
                $this->line('FizzBuzz');
            } elseif ($i % 3 === 0) {
                $this->line('Fizz');
            } elseif ($i % 5 === 0) {
                $this->line('Buzz');
            } else {
                $this->line($i);
            }
        }
    }
}
