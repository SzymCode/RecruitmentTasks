<?php

namespace App\Services;

use App\Models\News;
use App\Transformers\NewsTransformer;

class NewsService
{
    public function __construct(private News $model){}

    public function getAll(): array
    {
        $model = $this->model->all();

        return fractal()
            ->collection($model)
            ->transformWith(new NewsTransformer())
            ->toArray()['data'];
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);

        $model->delete();
    }

    public function getNewsById($id)
    {
        $model = $this->model->findOrFail($id);

        return fractal()
            ->item($model)
            ->transformWith(new NewsTransformer())
            ->toArray()['data'];
    }

    public function getNewsByAuthor($authorId)
    {
        $models = $this->model->whereHas('authors', function ($query) use ($authorId) {
            $query->where('authors.id', $authorId);
        })->get();

        return fractal()
            ->collection($models)
            ->transformWith(new NewsTransformer())
            ->toArray()['data'];
    }
}
