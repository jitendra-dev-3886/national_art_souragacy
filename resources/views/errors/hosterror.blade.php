<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>400 Bad Request</title>
    <style>
        body { font-family: sans-serif; background: #f8f8f8; padding: 2rem; }
        .container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 8px; }
        h1 { color: #cc0000; }
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>400 Bad Request</h1>
        {{-- <p>{{ $exception->getMessage() ?? 'Your request could not be understood by the server.' }}</p> --}}

        <a href="{{ url('/') }}" class="button">Back to Home</a>
    </div>
</body>
</html>
