<?php

use App\Models\Article;

describe('200', function () {
    test('authorized index api', function () {
        Article::factory(3)->create();

        $this->getJson(route('articles.index'))
            ->assertOk();
    });
});
