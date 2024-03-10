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
        <h1>Top Authors of Last Week</h1>

        @foreach ($authors as $index => $author)
            <div>
                <strong>{{ $index + 1 }}. Author:</strong> {{ $author['author']['name'] }}<br>
                <strong>News Count:</strong> {{ $author['news_count'] }}
                <br>
            </div>
        @endforeach
    </div>
</body>
</html>
