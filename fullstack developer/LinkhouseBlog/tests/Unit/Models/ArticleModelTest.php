<?php

use App\Models\Article;

beforeEach(function () {
    $this->article = Article::factory()->create();
});


it('can be created', function () {
    expect($this->article)->toBeInstanceOf(Article::class);
});

it('can get id', function () {
    expect($this->article->getId())->tobeInt();
});

it('can get guid', function () {
    expect($this->article->getGuid())->toBeString();
});

it('can get title', function () {
    expect($this->article->getTitle())->toBeString();
});

it('can get description', function () {
    expect($this->article->getDescription())->toBeString();
});

it('can get category', function () {
    expect($this->article->getCategory())->toBeString();
});

it('can get publication date', function () {
    expect($this->article->getPubDate())->toBeString();
});
