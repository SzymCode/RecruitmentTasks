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
        <h1>News by Author</h1>

        <h2>{{ $author['name'] }}'s Articles</h2>

        @foreach ($news as $index => $item)
            <div>
                <strong>Title:</strong> {{ $item['title'] }}<br>
                <strong>Description:</strong> {{ $item['description'] }}<br>
                <strong>Published At:</strong> {{ $item['created_at'] }}<br>
                <strong>ID:</strong> {{ $item['id'] }}<br>
                <br>
            </div>
        @endforeach
    </div>
</body>
</html>
