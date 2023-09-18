<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\AuthorizationException;

use App\Models\User;

class UsersController extends Controller
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
        })->only('index', 'store', 'update', 'delete');
    }

    public function index()
    {
        return response()->json(['results' => User::latest()->paginate(20)]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function update(UpdateUserRequest $request, User $user) 
    {
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);
    
        return response()->json(['user' => $user->only('id', 'name', 'email', 'role')]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Successfully deleted user.']);
    }

}
