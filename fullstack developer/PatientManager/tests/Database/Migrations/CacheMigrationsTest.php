<?php

use Illuminate\Support\Facades\Schema;

test('can create cache table', function (): void {
    expect(Schema::hasTable('cache'))->toBeTrue()
        ->and(Schema::hasColumns('cache', [
            'key',
            'value',
            'expiration',
        ]))->toBeTrue();
});

test('can create cache_locks table', function (): void {
    expect(Schema::hasTable('cache_locks'))->toBeTrue()
        ->and(Schema::hasColumns('cache_locks', [
            'key',
            'owner',
            'expiration',
        ]))->toBeTrue();
});

test('can rollback cache migrations', function (): void {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('cache'))->toBeFalse();
});

test('can rollback cache_locks migrations', function (): void {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('cache_locks'))->toBeFalse();
});
