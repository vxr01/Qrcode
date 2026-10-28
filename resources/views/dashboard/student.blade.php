
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | SSC QR Payment System</title>
</head>
<body>
    <h1>SSC QR Payment System</h1>
    <h2>Student Dashboard</h2>

    <p>Welcome, {{ auth()->user()->name }}!</p>

    <p>You are logged in as a Student.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
