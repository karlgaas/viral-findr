<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Data</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Instagram Data</h1>
        <form action="{{ route('search') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Instagram Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        @if (isset($data) && !empty($data))
            <ul>
                @foreach ($data as $item)
                    <li>
                        <h2>{{ isset($item['caption']) ? $item['caption'] : '' }}</h2>
                        <p><strong>Type:</strong> {{ isset($item['type']) ? $item['type'] : '' }}</p>
                        <p><strong>Video URL:</strong> <a href=" {{ isset($item['videoUrl']) ? $item['videoUrl'] : '' }}" target="_blank">Watch Video</a></p>
                        <p><strong>Display URL:</strong> <img src=" {{ isset($item['displayUrl']) ? $item['displayUrl'] : '' }}" alt="Instagram Image" style="width: 100%; max-width: 600px;"></p>
                        <p><strong>Likes:</strong> {{ isset($item['likesCount']) ? $item['likesCount'] : '' }}</p>
                        <p><strong>Views:</strong>{{ isset($item['videoViewCount']) ? $item['videoViewCount'] : '' }} </p>
                        <p><strong>Owner:</strong> {{ isset($item['ownerUsername']) ? $item['ownerUsername'] : '' }} </p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No data available.</p>
        @endif
    </div>
</body>
</html>
