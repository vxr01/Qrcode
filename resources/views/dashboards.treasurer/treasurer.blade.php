
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasurer Dashboard | SSC QR Payment System</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        header {
            background: #123b70;
            color: white;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        header h2 {
            margin: 0;
            font-size: 20px;
        }

        button {
            padding: 10px 16px;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        main {
            width: 90%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        h1, h3 {
            color: #123b70;
        }
    </style>
</head>
<body>

    <header>
        <h2>SSC QR Payment System</h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <h1>Treasurer Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}!</p>

        <section class="card">
            <h3>Collection Monitoring</h3>
            <p>
                Department collections, year-level totals, and payment
                summaries will appear here when the payment module is connected.
            </p>
        </section>

        <section class="card">
            <h3>Payment Verification</h3>
            <p>
                Pending payment submissions and payment verification
                features can be added to this section.
            </p>
        </section>
    </main>

</body>
</html>
