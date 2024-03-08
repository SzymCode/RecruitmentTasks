<?php

use App\Models\Author;


it('creates record successfully', function () {
    $author = Author::factory()->create();

    $this->assertDatabaseCount('authors', 1);
    $this->assertDatabaseHas('authors', [
        'id' => $author->id,
        'name' => $author->name,
        'created_at' => $author->created_at,
        'updated_at' => $author->updated_at
    ]);
});

it('creates multiple records successfully', function () {
    $authors = Author::factory()->count(3)->create();

    $this->assertDatabaseCount('authors', 3);
    foreach ($authors as $item) {
        $this->assertDatabaseHas('authors', [
            'id' => $item->id,
            'name' => $item->name,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at
        ]);
    }
});
