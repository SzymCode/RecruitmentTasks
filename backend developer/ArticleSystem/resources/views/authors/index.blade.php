<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArticleSystem</title>

    @vite(['resources/sass/app.scss', 'resources/js/utils/handleToggleForm.js'])
</head>
<body>
<div class="card">
    <div class="cardHeader">
        <h1>Authors List</h1>

        <div>
            <button onclick="toggleForm('post')" class="successButton">
                Add Author
            </button>
        </div>
    </div>

    <form id="postForm" method="POST" action="{{ route('authors.store') }}" style="display: none;" class="postForm">
        @csrf
        <div>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
        </div>

        <button type="submit" class="successButton">
            Submit
        </button>
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
                <div>
                    <button onclick="toggleForm('update', '{{ $item['id'] }}')" class="infoButton">
                        Edit
                    </button>
                </div>
                <form method="POST" action="{{ route('authors.delete', $item['id']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dangerButton">
                        Delete
                    </button>
                </form>
            </div>
            <br>
        </div>
        <form id="updateForm{{ $item['id'] }}" method="POST" action="{{ route('authors.update', $item['id']) }}" style="display: none;" class="updateForm">
            @csrf
            @method('PUT')
            <div>
                <label for="updateName{{ $item['id'] }}">Name:</label><br>
                <input type="text" id="updateName{{ $item['id'] }}" name="name" value="{{ $item['name'] }}"><br>
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
