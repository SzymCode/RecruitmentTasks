<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use function Pest\Laravel\artisan;

it('prints Fizz for multiples of 3', function () {
    $output = $this->artisan('fizzbuzz');
    expect($output)->toContain('Fizz')->not->toContain('Buzz');
    expect($output)->toContain('Fizz')->not->toContain('FizzBuzz');
});

it('prints Buzz for multiples of 5', function () {
    $output = Artisan::output();
    expect($output)->toContain('Buzz')->not->toContain('Fizz');
    expect($output)->toContain('Buzz')->not->toContain('FizzBuzz');
});
