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
        <h1>Authors List</h1>

        <div>
            <button onclick="toggleForm()">Add Author</button>
        </div>
    </div>

    <form id="postForm" method="POST" action="{{ route('authors.store') }}" style="display: none;" class="postForm">
        @csrf
        <div>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
        </div>

        <button type="submit">Submit</button>
    </form>

    @foreach ($authors as $item)
        <div class="item">
            <div class="itemData">
                <strong>Name:</strong> {{ $item['name'] }}<br>
                <strong>Created At:</strong> {{ $item['created_at'] }}<br>
                <strong>Updated At:</strong> {{ $item['updated_at'] }}<br>
                <strong>ID:</strong> {{ $item['id'] }}<br>
            </div>
            <div class="itemButtons">
                <button onclick="toggleEditForm('{{ $item['id'] }}')">Edit</button>
                <form method="POST" action="{{ route('authors.delete', $item['id']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </div>
            <br>
        </div>
        <form id="editForm{{ $item['id'] }}" method="POST" action="{{ route('authors.update', $item['id']) }}" style="display: none;" class="editForm">
            @csrf
            @method('PUT')
            <div>
                <label for="editName{{ $item['id'] }}">Name:</label><br>
                <input type="text" id="editName{{ $item['id'] }}" name="name" value="{{ $item['name'] }}"><br>
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

    function toggleEditForm(authorId) {
        let form = document.getElementById("editForm" + authorId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
</script>
</body>
</html>
