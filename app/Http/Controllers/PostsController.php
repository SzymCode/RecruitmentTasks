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

    public function index()
    {
        return response()->json(['results' => Post::latest()->paginate(20)]);
    }

    public function store(StorePostRequest $request)
    {

        $post = Post::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'created_at' => $request['created_at'],
        ]);

        return response()->json(['post' => $post], 201);
    }

    public function update(UpdatePostRequest $request, Post $post) 
    {
        $post->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'created_at' => $request->input('created_at'),
        ]);
    
        return response()->json(['post' => $post->only('id', 'title', 'description', 'created_at')]);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Successfully deleted post.']);
    }
}
