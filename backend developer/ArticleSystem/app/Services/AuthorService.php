<?php

namespace App\Services;

use App\Models\Author;
use App\Transformers\AuthorTransformer;

class AuthorService
{
    public function __construct(private Author $model){}

    public function getAll(): array
    {
        $model = $this->model->all();

        return fractal()
            ->collection($model)
            ->transformWith(new AuthorTransformer())
            ->toArray()['data'];
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);

        $model->delete();
    }

    public function getTopAuthorsLastWeek()
    {
        $oneWeekAgo = now()->subWeek();

        $topAuthors = Author::select([
            'authors.id',
            'authors.name',
            'authors.created_at',
            'authors.updated_at',
        ])
            ->withCount(['news' => function ($query) use ($oneWeekAgo) {
                $query->where('created_at', '>=', $oneWeekAgo);
            }])
            ->has('news', '>', 0)
            ->orderByDesc('news_count')
            ->limit(3)
            ->get();

        return $topAuthors->map(function ($author) {
            return [
                'author' => fractal()
                    ->item($author)
                    ->transformWith(new AuthorTransformer())
                    ->toArray()['data'],
                'news_count' => $author->news_count,
            ];
        });
    }
}
