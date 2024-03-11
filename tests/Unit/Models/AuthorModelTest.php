<?php

use App\Models\Author;


it('can be created', function () {
    $author = Author::factory()->create();

    expect($author)->toBeInstanceOf(Author::class);
});
