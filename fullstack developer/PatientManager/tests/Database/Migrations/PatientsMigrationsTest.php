<?php

use Illuminate\Support\Facades\Schema;

it('can create patients table', function (): void {
    expect(Schema::hasTable('patients'))->toBeTrue()
        ->and(Schema::hasColumns('patients', [
            'id',
            'name',
            'surname',
            'sex',
            'birth_date',
            'created_at',
            'updated_at',
        ]))->toBeTrue();
});

it('can be rolled back', function (): void {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('patients'))->toBeFalse();
});
