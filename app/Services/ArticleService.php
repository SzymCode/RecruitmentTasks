<?php

namespace App\Services;

use App\Transformers\ArticleTransformer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

readonly class ArticleService
{
    public function getAll(): array|GuzzleException
    {
        $client = new Client();

        $response = $client->get('https://linkhouse.pl/feed/');

        $xmlData = $response->getBody()->getContents();
        $articles = [];

        $xmlObject = simplexml_load_string($xmlData);

        foreach ($xmlObject->channel->item as $item) {
            $article = [
                'guid' => (string) $item->guid,
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'category' => (string) $item->category,
                'pub_date' => (string) $item->pubDate,
            ];

            $articles[] = $article;
        }

        return fractal()
            ->collection($articles)
            ->transformWith(new ArticleTransformer())
            ->toArray()['data'];
    }
}
