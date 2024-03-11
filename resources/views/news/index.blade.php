@extends('layouts.app')

@section('content')
<div class="card">
    <div class="cardHeader">
        <h1>
            News List
        </h1>

        <div>
            <button onclick="toggleForm('search-by-id')" class="infoButton">
                Search by ID
            </button>
            <button onclick="toggleForm('search-by-author')" class="infoButton">
                Search by Author
            </button>
            <button onclick="toggleForm('post')" class="successButton">
                Add News
            </button>
        </div>
    </div>

    <form method="GET" action="" id="searchByIdForm" class="searchByIdForm" onsubmit="showNewsById(event)" style="display: none;">
        @csrf
        <label for="newsId">News ID:</label>
        <input type="text" id="newsId">
        <button type="submit" class="successButton">Show News</button>
    </form>
    <form method="GET" action="" id="searchByAuthorForm" class="searchByAuthorForm" onsubmit="showNewsByAuthor(event)" style="display: none;">
        @csrf
        <label for="authorId">Author ID:</label>
        <input type="text" id="authorId">
        <button type="submit" class="successButton">Show News</button>
    </form>
    <form
        id="postForm"
        method="POST"
        action="{{ route('news.store') }}"
        style="display: none;"
        class="postForm"
    >
        @csrf
        <div>
            <label for="title">
                Title:
            </label>
            <input type="text" id="title" name="title">
        </div>

        <div>
            <label for="description">
                Description:
            </label>
            <textarea id="description" name="description"></textarea>
        </div>

        <button type="submit" class="successButton">
            Submit
        </button>
    </form>

    @foreach ($news as $item)
        <div class="item">
            <div class="itemData">
                <div>
                    <strong>
                        Title:
                    </strong>
                    {{ $item['title'] }}
                </div>
                <div>
                    <strong>
                        Description:
                    </strong>
                    {{ $item['description'] }}
                </div>
                <div>
                    <strong>
                        Created At:
                    </strong>
                    {{ $item['created_at'] }}
                </div>
                <div>
                    <strong>
                        Updated At:
                    </strong>
                    {{ $item['updated_at'] }}
                </div>

                <div>
                    <strong>
                        ID:
                    </strong>
                    {{ $item['id'] }}
                </div>
            </div>
            <div class="itemButtons">
                <div>
                    <button
                        onclick="toggleForm('update', '{{ $item['id'] }}')"
                        class="infoButton"
                    >
                        Edit
                    </button>
                </div>
                <form
                    method="POST"
                    action="{{ route('news.delete', $item['id']) }}"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dangerButton">
                        Delete
                    </button>
                </form>
            </div>
            <br>
            <form
                id="updateForm{{ $item['id'] }}"
                method="POST"
                action="{{ route('news.update', $item['id']) }}"
                style="display: none;"
                class="updateForm"
            >
                @csrf
                @method('PUT')
                <div>
                    <label for="updateTitle{{ $item['id'] }}">
                        Title:
                    </label>
                    <input type="text" id="updateTitle{{ $item['id'] }}" name="title" value="{{ $item['title'] }}">
                </div>

                <div>
                    <label for="updateDescription{{ $item['id'] }}">
                        Description:
                    </label>
                    <textarea id="updateDescription{{ $item['id'] }}" name="description">
                        {{ $item['description'] }}
                    </textarea>
                </div>

                <button type="submit" class="successButton">
                    Update
                </button>
            </form>
        </div>
    @endforeach
</div>
@endsection

<script>
    function showNewsById(event) {
        event.preventDefault();
        const newsId = document.getElementById("newsId").value;
        window.location.href = "{{ route('news.show', ':newsId') }}".replace(':newsId', newsId);
    }
    function showNewsByAuthor(event) {
        event.preventDefault();
        const authorId = document.getElementById("authorId").value;
        window.location.href = "{{ route('news.show-by-author', ':authorId') }}".replace(':authorId', authorId);
    }
    function toggleForm(method, newsId = null) {
        let form;
        switch (method) {
            case "post":
                form = document.getElementById("postForm");
                break;
            case "update":
                form = document.getElementById("updateForm" + newsId);
                break;
            case "search-by-id":
                form = document.getElementById("searchByIdForm");
                break;
            case "search-by-author":
                form = document.getElementById("searchByAuthorForm");
                break;
            default:
                return;
        }
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
</script>
