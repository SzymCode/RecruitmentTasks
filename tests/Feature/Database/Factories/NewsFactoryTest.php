<?php

use App\Models\News;


it('creates record successfully', function () {
    $news = News::factory()->create();

    $this->assertDatabaseCount('news', 1);
    $this->assertDatabaseHas('news', [
        'id' => $news->id,
        'title' => $news->title,
        'description' => $news->description,
        'created_at' => $news->created_at,
        'updated_at' => $news->updated_at
    ]);
});

it('creates multiple records successfully', function () {
    $news = News::factory()->count(3)->create();

    $this->assertDatabaseCount('news', 3);
    foreach ($news as $item) {
        $this->assertDatabaseHas('news', [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at
        ]);
    }
});
