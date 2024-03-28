<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform($article): array
    {
        return [
            'guid' => $article['guid'],
            'title' => $article['title'],
            'link' => $article['link'],
            'description' => $article['description'],
            'category' => $article['category'],
            'pub_date' => $article['pub_date'],
        ];
    }
}
