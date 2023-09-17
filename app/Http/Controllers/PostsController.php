<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        return response()->json(['results' => Post::latest()->paginate(20)]);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'created_at' => $data['created_at'],
        ]);

        return response()->json(['post' => $post], 201);
    }
}
