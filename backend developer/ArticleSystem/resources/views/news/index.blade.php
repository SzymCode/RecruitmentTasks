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
            <button onclick="toggleForm('post')" class="successButton">
                Add News
            </button>
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

        <button type="submit" class="successButton">
            Submit
        </button>
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
                <div>
                    <button onclick="toggleForm('update', '{{ $item['id'] }}')" class="infoButton">
                        Edit
                    </button>
                </div>
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
        <form id="updateForm{{ $item['id'] }}" method="POST" action="{{ route('news.update', $item['id']) }}" style="display: none;" class="updateForm">
            @csrf
            @method('PUT')
            <div>
                <label for="updateTitle{{ $item['id'] }}">Title:</label><br>
                <input type="text" id="updateTitle{{ $item['id'] }}" name="title" value="{{ $item['title'] }}"><br>
            </div>

            <div>
                <label for="updateDescription{{ $item['id'] }}">Description:</label><br>
                <textarea id="updateDescription{{ $item['id'] }}" name="description">{{ $item['description'] }}</textarea><br>
            </div>

            <button type="submit" class="successButton">
                Update
            </button>
        </form>
    @endforeach
</div>

<script>
    function toggleForm(method, newsId = null) {
        let form;
        switch (method) {
            case "post":
                form = document.getElementById("postForm");
                break;
            case "update":
                form = document.getElementById("updateForm" + newsId);
                break;
            default:
                return;
        }
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
</script>
</body>
</html>
