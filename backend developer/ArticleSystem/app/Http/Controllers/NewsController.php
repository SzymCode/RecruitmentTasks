<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\NewsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    protected NewsService $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function getNewsById($id): View
    {
        $result = $this->service->getNewsById($id);

        return view('news.show', $result);
    }

    public function getNewsByIdApi($id): JsonResponse
    {
        $result = $this->service->getNewsById($id);

        return response()->json($result);
    }

    public function getNewsByAuthor($authorId): View
    {
        $author = Author::findOrFail($authorId);
        $news = $this->service->getNewsByAuthor($authorId);

        return view('news.by_author', ['news' => $news, 'author' => $author]);
    }

    public function getNewsByAuthorApi($authorId): JsonResponse
    {
        $news = $this->service->getNewsByAuthor($authorId);

        return response()->json($news);
    }
}
