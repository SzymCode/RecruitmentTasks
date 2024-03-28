<?php

use Illuminate\Support\Facades\Schema;

it('can create table', function () {
    expect(Schema::hasTable('articles'))->toBeTrue();

    expect(Schema::hasColumns('articles', [
        'id', 'guid', 'title', 'link', 'description', 'category', 'pub_date', 'created_at', 'updated_at'
    ]))->toBeTrue();
});

it('can be rolled back', function () {
    $this->artisan('migrate:rollback');

    expect(Schema::hasTable('articles'))->toBeFalse();
});
