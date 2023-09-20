@extends('layouts.app')

@section('content')
    <div>
        @if (Auth::user()->isAdmin())
            <users-management-dashboard></users-management-dashboard>
        @endif
        <posts-management-dashboard></posts-management-dashboard>
    </div>
@endsection
