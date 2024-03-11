<?php

use App\Models\News;


it('can be created', function () {
    $news = News::factory()->create();

    expect($news)->toBeInstanceOf(News::class);
});
