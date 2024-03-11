<?php

namespace App\Transformers;

use App\Contracts\NewsShouldReceiveFields;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract
{
    public function transform(NewsShouldReceiveFields $model): array
    {
        return [
            'id' => $model->getId(),
            'title' => $model->getTitle(),
            'description' => $model->getDescription(),
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt()
        ];
    }
}
