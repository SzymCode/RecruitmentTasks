@extends('layouts.app')

@section('content')
<div class="card">
    <div class="cardHeader">
        <h1>News Details</h1>
    </div>

    <div class="itemData">
        <strong>Title:</strong> {{ $title }}<br>
        <strong>Description:</strong> {{ $description }}<br>
        <strong>Published At:</strong> {{ $created_at }}<br>
        <strong>Updated At:</strong> {{ $updated_at }}<br>
    </div>
</div>
@endsection
