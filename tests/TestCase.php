<?php

namespace Tests;

use App\Models\Author;
use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createNews(): Collection
    {
        return News::factory(5)->create();
    }

    protected function createAuthors(): Collection
    {
        return Author::factory(5)->create();
    }
}
