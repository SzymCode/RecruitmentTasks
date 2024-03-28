<?php

namespace App\Transformers;

use App\Contracts\ArticleShouldReceiveFields;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(ArticleShouldReceiveFields $model): array
    {
        return [
            'id' => $model->getId(),
            'guid' => $model->getGuid(),
            'title' => $model->getTitle(),
            'description' => $model->getDescription(),
            'link' => $model->getLink(),
            'category' => $model->getCategory(),
            'pub_date' => $model->getPubDate()
        ];
    }
}
