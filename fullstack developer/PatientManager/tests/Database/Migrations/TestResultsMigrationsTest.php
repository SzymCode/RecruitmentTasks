<?php

use Illuminate\Support\Facades\Schema;

test('can create test_results table', function (): void {
    expect(Schema::hasTable('test_results'))->toBeTrue()
        ->and(Schema::hasColumns('test_results', [
            'id',
            'order_id',
            'test_name',
            'test_value',
            'test_reference',
            'created_at',
            'updated_at',
        ]))->toBeTrue();
});

test('can be rolled back', function (): void {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('test_results'))->toBeFalse();
});
