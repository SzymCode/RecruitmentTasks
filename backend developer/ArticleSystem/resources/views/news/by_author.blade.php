@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>
            {{ $author['name'] }}'s Articles
        </h1>

        @foreach ($news as $index => $item)
            <div class="item">
                <div class="itemData">
                    <div>
                        <strong>
                            Title:
                        </strong>
                        {{ $item['title'] }}
                    </div>
                    <div>
                        <strong>
                            Description:
                        </strong>
                        {{ $item['description'] }}
                    </div>
                    <div>
                        <strong>
                            Published At:
                        </strong>
                        {{ $item['created_at'] }}
                    </div>
                    <div>
                        <strong>
                            ID:
                        </strong>
                        {{ $item['id'] }}
                    </div>
                </div>
                <div class="itemButtons">
                    <form method="POST" action="{{ route('news.delete', $item['id']) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dangerButton">
                            Delete
                        </button>
                    </form>
                </div>
                <br>
            </div>
        @endforeach
    </div>
@endsection
