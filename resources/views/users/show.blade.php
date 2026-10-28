
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View User | SSC Payment System</title>

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
            margin: 0;
            font-size: 19px;
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

        .profile {
            display: flex;
            align-items: center;
            gap: 18px;
            padding-bottom: 24px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 25px;
        }

        .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .profile h2 {
            font-size: 23px;
            margin-bottom: 8px;
            overflow-wrap: anywhere;
        }

        .role {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background: #dbeafe;
            color: #1d4ed8;
            margin-top: 10px;
        }

        .role.treasurer {
            background: #fef3c7;
            color: #92400e;
        }

        .role.student {
            background: #dcfce7;
            color: #166534;
        }

        .section-title {
            margin: 0 0 18px;
            font-size: 18px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 24px;
        }

        .detail {
            padding: 17px 0;
            border-bottom: 1px solid #e5e7eb;
            min-width: 0;
        }

        .detail-label {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
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

            .details-grid {
                grid-template-columns: 1fr;
            }

            .profile h2 {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>View User</h1>
            <p class="muted">
                View the details of a registered SSC Payment System account.
            </p>
        </div>

        <a href="{{ route('users.index') }}" class="btn secondary">
            &larr; Back to Users
        </a>
    </div>

    @if(session('success'))
        <div style="padding:12px; border-radius:6px; background:#dcfce7; color:#166534; margin-bottom:18px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="profile">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h2>{{ $user->name }}</h2>

                <p class="muted">
                    Account ID: {{ $user->id }}
                </p>

                <span class="role
                    {{ $user->role === 'Treasurer' ? 'treasurer' : ($user->role === 'Student' ? 'student' : '') }}">
                    {{ $user->role }}
                </span>
            </div>
        </div>

        <h2 class="section-title">Account Information</h2>

        <div class="details-grid">

            <div class="detail">
                <span class="detail-label">Full Name</span>
                <div class="detail-value">{{ $user->name }}</div>
            </div>

            <div class="detail">
                <span class="detail-label">Student ID</span>
                <div class="detail-value">
                    {{ $user->student_id ?: 'Not provided' }}
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">Email Address</span>
                <div class="detail-value">{{ $user->email }}</div>
            </div>

            <div class="detail">
                <span class="detail-label">Account Role</span>
                <div class="detail-value">{{ $user->role }}</div>
            </div>

            <div class="detail">
                <span class="detail-label">User Record ID</span>
                <div class="detail-value">{{ $user->id }}</div>
            </div>

            <div class="detail">
                <span class="detail-label">Account Created</span>
                <div class="detail-value">
                    {{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'Not available' }}
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">Last Updated</span>
                <div class="detail-value">
                    {{ $user->updated_at ? $user->updated_at->format('M d, Y h:i A') : 'Not available' }}
                </div>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn secondary">
                Back to Users
            </a>

            <a href="{{ route('users.edit', $user) }}" class="btn primary">
                Edit User
            </a>
        </div>

    </div>
</div>
</body>
</html>
