<?php

use Illuminate\Support\Facades\Schema;

it('can create orders table', function (): void {
    expect(Schema::hasTable('orders'))->toBeTrue()
        ->and(Schema::hasColumns('orders', [
            'id',
            'patient_id',
            'created_at',
            'updated_at',
        ]))->toBeTrue();
});

it('can be rolled back', function (): void {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('orders'))->toBeFalse();
});
