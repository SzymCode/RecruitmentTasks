<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            /**
             *  You can check if it works without '!' before Auth:
             *  if(Auth::user()->isAdmin())
            */
            if(!Auth::user()->isAdmin()) {
                throw new AuthorizationException('Unauthorized', 403);
            }
            return $next($request);
        })->only('store', 'update', 'delete');
    }
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('title_contains')) {
            $searchTerm = $request->input('title_contains');
            $query->where('title', 'LIKE', '%' . $searchTerm . '%');
        }

        $posts = $query->latest()->paginate(10);

        return response()->json(['results' => $posts]);
    }

    public function store(StorePostRequest $request)
    {
        $post = new Post;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->tags = $request->input('tags');
        $post->created_at = $request->input('created_at');
        $post->save();

        return response()->json(['post' => $post], 201);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->tags = $request->input('tags');
        $post->created_at = $request->input('created_at');
        $post->save();

        return response()->json(['post' => $post->only('id', 'title', 'description', 'tags', 'created_at')]);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Successfully deleted post.']);
    }
}
