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
    <div class="cardHeader">
        <h1>News List</h1>

        <div>
            <button onclick="toggleForm()">Add News</button>
        </div>
    </div>

    <form id="postForm" method="POST" action="{{ route('news.store') }}" style="display: none;" class="postForm">
        @csrf
        <div>
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title"><br>
        </div>

        <div>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br>
        </div>

        <button type="submit">Submit</button>
    </form>

    @foreach ($news as $item)
        <div class="item">
            <div class="itemData">
                <strong>Title:</strong> {{ $item['title'] }}<br>
                <strong>Description:</strong> {{ $item['description'] }}<br>
                <strong>Created At:</strong> {{ $item['created_at'] }}<br>
                <strong>Updated At:</strong> {{ $item['updated_at'] }}<br>
                <strong>ID:</strong> {{ $item['id'] }}<br>
            </div>
            <div class="itemButtons">
                <button onclick="toggleEditForm('{{ $item['id'] }}')">Edit</button>
                <form method="POST" action="{{ route('news.delete', $item['id']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </div>
            <br>
        </div>
        <form id="editForm{{ $item['id'] }}" method="POST" action="{{ route('news.update', $item['id']) }}" style="display: none;" class="editForm">
            @csrf
            @method('PUT')
            <div>
                <label for="editTitle{{ $item['id'] }}">Title:</label><br>
                <input type="text" id="editTitle{{ $item['id'] }}" name="title" value="{{ $item['title'] }}"><br>
            </div>

            <div>
                <label for="editDescription{{ $item['id'] }}">Description:</label><br>
                <textarea id="editDescription{{ $item['id'] }}" name="description">{{ $item['description'] }}</textarea><br>
            </div>

            <button type="submit">Update</button>
        </form>
    @endforeach
</div>

<script>
    function toggleForm() {
        let form = document.getElementById("postForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    }

    function toggleEditForm(newsId) {
        let form = document.getElementById("editForm" + newsId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
</script>
</body>
</html>
