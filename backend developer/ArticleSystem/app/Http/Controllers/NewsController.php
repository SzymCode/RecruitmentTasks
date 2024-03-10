<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\NewsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NewsController extends Controller
{
    protected NewsService $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    /**
     *  CRUD methods with views
     */
    public function index(): View
    {
        $results = $this->service->getAll();

        $news = collect($results);

        return view('news.index', ['news' => $news]);
    }
    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'News deleted successfully.');
    }


    /**
     *  CRUD methods for only API requests
     */
    public function indexApi(): JsonResponse
    {
        $results = $this->service->getAll();

        return response()->json($results);
    }
    public function destroyApi($id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json([
            'deleted' => true,
        ]);
    }

    /**
     *  1. Get article by some id
     *  2. Get all articles for given author
     */
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
