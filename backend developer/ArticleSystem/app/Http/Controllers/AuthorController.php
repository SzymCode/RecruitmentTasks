<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class AuthorController extends Controller
{
    protected AuthorService $service;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }

    /**
     *  CRUD methods
     */
    public function index(): View
    {
        $results = $this->service->getAll();

        return view('authors.index', ['authors' => $results]);
    }
    public function indexApi(): JsonResponse
    {
        $results = $this->service->getAll();

        return response()->json($results);
    }


    /**
     *  3. Get top 3 authors that wrote the most articles last week
     */
    public function getTopAuthorsLastWeek(): View
    {
        $authors = $this->service->getTopAuthorsLastWeek();

        return view('authors.top_authors', ['authors' => $authors]);
    }

    public function getTopAuthorsLastWeekApi(): JsonResponse
    {
        $result = $this->service->getTopAuthorsLastWeek();

        return response()->json($result);
    }
}
