<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    protected NewsService $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function getNewsById($id): JsonResponse
    {
        $result = $this->service->getNewsById($id);

        return response()->json($result);
    }

    public function getNewsByAuthor($authorId): JsonResponse
    {
        $result = $this->service->getNewsByAuthor($authorId);

        return response()->json($result);
    }
}
