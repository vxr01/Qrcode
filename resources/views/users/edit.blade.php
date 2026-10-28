
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | SSC Payment System</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        h2 {
            margin: 0 0 6px;
            font-size: 20px;
        }

        .muted {
            color: #6b7280;
            margin: 0;
            line-height: 1.5;
        }

        .card {
            background: #fff;
            padding: 26px;
            border-radius: 12px;
            box-shadow: 0 3px 14px rgba(0, 0, 0, .05);
            margin-bottom: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .avatar {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
            color: #1f2937;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .help-text {
            color: #6b7280;
            font-size: 12px;
            margin-top: 7px;
            line-height: 1.5;
        }

        .field-error {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 6px;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 6px;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .section-title {
            margin: 25px 0 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            border-top: 1px solid #e5e7eb;
            padding-top: 22px;
            margin-top: 8px;
        }

        .btn {
            display: inline-block;
            border: 0;
            border-radius: 6px;
            padding: 11px 16px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .primary:hover {
            background: #1d4ed8;
        }

        .secondary {
            background: #e5e7eb;
            color: #1f2937;
        }

        .secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px auto;
                padding: 0 12px;
            }

            .card {
                padding: 18px;
            }

            h1 {
                font-size: 23px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .full-width {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Edit User</h1>
            <p class="muted">Update account information and access role.</p>
        </div>

        <a href="{{ route('users.index') }}" class="btn secondary">
            &larr; Back to Users
        </a>
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <strong>Please correct the following:</strong>
            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <div class="user-info">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h2>{{ $user->name }}</h2>
                <p class="muted">
                    User ID: {{ $user->id }}
                </p>
                <p class="muted">
                    Current role: {{ $user->role }}
                </p>
            </div>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <h2 class="section-title">Account Information</h2>

            <div class="form-grid">

                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        maxlength="255"
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input
                        type="text"
                        id="student_id"
                        name="student_id"
                        value="{{ old('student_id', $user->student_id) }}"
                        maxlength="100"
                        placeholder="Enter student ID"
                    >
                    @error('student_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="email">Email Address *</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        maxlength="255"
                        autocomplete="email"
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="role">User Role *</label>
                    <select id="role" name="role" required>
                        <option value="Administrator"
                            {{ old('role', $user->role) === 'Administrator' ? 'selected' : '' }}>
                            Administrator
                        </option>

                        <option value="Treasurer"
                            {{ old('role', $user->role) === 'Treasurer' ? 'selected' : '' }}>
                            Treasurer
                        </option>

                        <option value="Student"
                            {{ old('role', $user->role) === 'Student' ? 'selected' : '' }}>
                            Student
                        </option>
                    </select>
                    @error('role')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <p class="help-text">
                        Choose the account's access role carefully.
                    </p>
                </div>

            </div>

            <h2 class="section-title">Change Password</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Leave blank to keep current password"
                    >
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Confirm New Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Re-enter new password"
                    >
                    <p class="help-text">
                        Only enter a password if you want to change it.
                    </p>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="btn secondary">
                    Cancel
                </a>

                <button type="submit" class="btn primary">
                    Save Changes
                </button>
            </div>

        </form>
    </div>

</div>
</body>
</html>
