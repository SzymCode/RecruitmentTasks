@extends('layouts.app')

@section('content')
    <div>
        <user-management-dashboard></user-management-dashboard>
        <div class="users_content card mt-3">
            <div class="card-body">
                <h3>Manage Users</h3>
            </div>
        </div>
        <div class="posts_content card mt-3">
            <div class="card-body">
                <h3>Manage Posts</h3>
            </div>
        </div>
    </div>
@endsection
