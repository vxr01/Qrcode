
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User | SSC QR Payment System</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 35px 16px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #1e293b;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,.07);
        }

        h1 { margin-top: 0; font-size: 27px; }
        .subtitle { color: #64748b; margin-bottom: 25px; }

        label {
            display: block;
            margin: 18px 0 7px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button, .back {
            border: 0;
            border-radius: 7px;
            padding: 12px 18px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
        }

        button {
            background: #1d4ed8;
            color: white;
        }

        .back {
            background: #e2e8f0;
            color: #1e293b;
        }

        .alert {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 7px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Add User</h1>
    <p class="subtitle">Create an administrator, treasurer, or student account.</p>

    @if ($errors->any())
        <div class="alert">
            <strong>Please correct the following:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <label for="name">Full Name</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name') }}"
            required
        >

        <label for="email">Email Address</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
        >

        <label for="student_id">Student ID (optional for staff)</label>
        <input
            id="student_id"
            name="student_id"
            type="text"
            value="{{ old('student_id') }}"
        >

        <label for="role">Account Role</label>
        <select id="role" name="role" required>
            <option value="Student" {{ old('role', 'Student') === 'Student' ? 'selected' : '' }}>Student</option>
            <option value="Treasurer" {{ old('role') === 'Treasurer' ? 'selected' : '' }}>Treasurer</option>
            <option value="Administrator" {{ old('role') === 'Administrator' ? 'selected' : '' }}>Administrator</option>
        </select>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" minlength="8" required>

        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>

        <div class="actions">
            <button type="submit">Create User</button>
            <a class="back" href="{{ route('users.index') }}">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
