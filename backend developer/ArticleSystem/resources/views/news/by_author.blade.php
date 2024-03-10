<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News by Author</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="card">
        <h1>News by Author</h1>

        <h2>{{ $author['name'] }}'s Articles</h2>

        @foreach ($news as $index => $article)
            <div>
                <strong>{{ $index + 1 }}. Title:</strong> {{ $article['title'] }}<br>
                <strong>Description:</strong> {{ $article['description'] }}<br>
                <strong>Published At:</strong> {{ $article['created_at'] }}<br>
                <br>
            </div>
        @endforeach
    </div>
</body>
</html>
