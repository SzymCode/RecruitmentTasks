<?php

namespace App\Transformers;

use App\Contracts\AuthorShouldReceiveFields;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    public function transform(AuthorShouldReceiveFields $model): array
    {
        return [
            'id' => $model->getId(),
            'name' => $model->getName(),
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt()
        ];
    }
}
