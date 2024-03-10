<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthorController extends Controller
{
    protected AuthorService $service;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }

    /**
     *  CRUD methods with views
     */
    public function index(): View
    {
        $results = $this->service->getAll();

        return view('authors.index', ['authors' => $results]);
    }
    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'Author deleted successfully.');
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
