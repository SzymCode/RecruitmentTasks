<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArticleSystem</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="card">
        <h1>{{ $author['name'] }}'s Articles</h1>

        @foreach ($news as $index => $item)
            <div>
                <strong>Title:</strong> {{ $item['title'] }}<br>
                <strong>Description:</strong> {{ $item['description'] }}<br>
                <strong>Published At:</strong> {{ $item['created_at'] }}<br>
                <strong>ID:</strong> {{ $item['id'] }}<br>
                <form method="POST" action="{{ route('news.delete', $item['id']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
                <br>
            </div>
        @endforeach
    </div>
</body>
</html>
