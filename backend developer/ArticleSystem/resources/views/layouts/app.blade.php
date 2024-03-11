<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ArticleSystem</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="navbar">
            <div class="navbarContainer">
                <h2>
                    ArticleSystem
                </h2>
                <div class="navbarItems">
                    <a href="/news">
                        News
                    </a>
                    <a href="/authors">
                        Authors
                    </a>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>
