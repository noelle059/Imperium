<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Page</title>
</head>
<body>
    <h1>Welcome to the Laravel Auth Example</h1>
    @if (Route::has('login'))
        <div>
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    @endif
</body>
</html>