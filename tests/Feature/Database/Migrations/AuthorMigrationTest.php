<?php

use Illuminate\Support\Facades\Schema;


it('can create table', function () {
    expect(Schema::hasTable('authors'))->toBeTrue();

    expect(Schema::hasColumns('authors', [
        'id',
        'name',
        'created_at',
        'updated_at'
    ]))->toBeTrue();
});

it('can be rolled back', function () {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('authors'))->toBeFalse();
});
