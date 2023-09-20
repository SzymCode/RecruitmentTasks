<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('name_contains')) {
            $searchTerm = $request->input('name_contains');
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $users = $query->latest()->paginate(10);

        return response()->json(['results' => $users]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json(['user' => $user], 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        return response()->json(['user' => $user->only('id', 'name', 'email', 'role')]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Successfully deleted user.']);
    }
}
