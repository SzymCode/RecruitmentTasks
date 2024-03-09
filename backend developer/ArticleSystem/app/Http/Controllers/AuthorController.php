<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    protected AuthorService $service;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }

    public function getTopAuthorsLastWeek(): JsonResponse
    {
        $result = $this->service->getTopAuthorsLastWeek();

        return response()->json($result);
    }
}
