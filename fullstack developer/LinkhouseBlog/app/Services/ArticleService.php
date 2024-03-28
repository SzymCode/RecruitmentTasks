<?php

namespace App\Services;

use App\Models\Article;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\JsonResponse;

readonly class ArticleService
{
    public function __construct(private Article $model) {}

    public function getAll(): array
    {
        $model = $this->model->all();

        return fractal()
            ->collection($model)
            ->transformWith(new ArticleTransformer())
            ->toArray()['data'];
    }
}
