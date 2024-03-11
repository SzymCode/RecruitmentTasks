@extends('layouts.app')

@section('content')
<div class="card">
    <div class="cardHeader">
        <h1>
            News List
        </h1>

        <div>
            <button onclick="toggleForm('post')" class="successButton">
                Add News
            </button>
        </div>
    </div>

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
