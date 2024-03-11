@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="cardHeader">
            <h1>
                Top Authors of Last Week
            </h1>
        </div>

        @foreach ($authors as $index => $author)
            <div class="item">
                <div class="itemData">
                    <div>
                        <strong>
                            {{ $index + 1 }}. Author:
                        </strong>
                        {{ $author['author']['name'] }}
                    </div>
                    <div>
                        <strong>
                            News Count:
                        </strong>
                        {{ $author['news_count'] }}
                    </div>
                    <br>
                </div>
            </div>
        @endforeach
    </div>
@endsection
