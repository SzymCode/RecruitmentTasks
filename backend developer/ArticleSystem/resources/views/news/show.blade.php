<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show News</title>
</head>
<body>
<h1>News Details</h1>

<div>
    <strong>Title:</strong> {{ $title }}<br>
    <strong>Description:</strong> {{ $description }}<br>
    <strong>Published At:</strong> {{ $created_at }}<br>
    <strong>Updated At:</strong> {{ $updated_at }}<br>
</div>
</body>
</html>
