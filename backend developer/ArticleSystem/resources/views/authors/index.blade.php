@extends('layouts.app')

@section('content')
    <div class="card">
    <div class="cardHeader">
        <h1>
            Authors List
        </h1>

        <div>
            <a href="/authors/top-authors">
                Top Authors
            </a>
            <button onclick="toggleForm('post')" class="successButton">
                Add Author
            </button>
        </div>
    </div>

    <form
        id="postForm"
        method="POST"
        action="{{ route('authors.store') }}"
        style="display: none;"
        class="postForm"
    >
        @csrf
        <div>
            <label for="name">
                Name:
            </label>
            <br>
            <input
                type="text"
                id="name"
                name="name"
            >
            <br>
        </div>

        <button type="submit" class="successButton">
            Submit
        </button>
    </form>

    @foreach ($authors as $item)
        <div class="item">
            <div class="itemData">
                <div>
                    <strong>
                        Name:
                    </strong>
                    {{ $item['name'] }}
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
            <form
                id="updateForm{{ $item['id'] }}"
                method="POST"
                action="{{ route('authors.update', $item['id']) }}"
                style="display: none;"
                class="updateForm"
            >
                @csrf
                @method('PUT')
                <div>
                    <label for="updateName{{ $item['id'] }}">
                        Name:
                    </label>
                    <input type="text" id="updateName{{ $item['id'] }}" name="name" value="{{ $item['name'] }}">
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
