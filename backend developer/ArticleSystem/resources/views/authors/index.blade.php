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
        <h1>Authors List</h1>

        @foreach ($authors as $item)
            <div>
                <strong>Name:</strong> {{ $item['name'] }}<br>
                <strong>Created At:</strong> {{ $item['created_at'] }}<br>
                <strong>Updated At:</strong> {{ $item['updated_at'] }}<br>
                <strong>ID:</strong> {{ $item['id'] }}<br>
                <form method="POST" action="{{ route('authors.delete', $item['id']) }}">
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
