<?php

use App\Models\Article;


it('creates record successfully', function () {
    $article = Article::factory()->create();

    $this->assertDatabaseCount('articles', 1);
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'guid' => $article->guid,
        'title' => $article->title,
        'link' => $article->link,
        'description' => $article->description,
        'category' => json_encode($article->category),
        'pub_date' => $article->pub_date,
    ]);
});

it('creates multiple records successfully', function () {
    $articles = Article::factory()->count(3)->create();

    $this->assertDatabaseCount('articles', 3);
    foreach ($articles as $article) {
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'guid' => $article->guid,
            'title' => $article->title,
            'link' => $article->link,
            'description' => $article->description,
            'category' => json_encode($article->category),
            'pub_date' => $article->pub_date,
        ]);
    }
});
