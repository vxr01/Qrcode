<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | SSC Payment System</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fb;
            color: #172b4d;
        }

        .container {
            max-width: 1160px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 { margin: 0 0 8px; font-size: 28px; }
        .subtitle { margin: 0; color: #64748b; }

        .header-actions, .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .card {
            background: #fff;
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 13px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, .06);
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-form input { flex: 1; min-width: 0; }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 10px 13px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            white-space: nowrap;
        }

        .primary { background: #2563eb; color: #fff; }
        .secondary { background: #e5e7eb; color: #172b4d; }
        .danger { background: #fee2e2; color: #b91c1c; }

        .primary:hover { background: #1d4ed8; }
        .secondary:hover { background: #d1d5db; }
        .danger:hover { background: #fecaca; }

        .section-title { margin: 0 0 6px; font-size: 23px; }
        .result-count { margin: 0 0 25px; color: #64748b; }

        .table-wrapper { width: 100%; overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead { background: #f8fafc; }

        th {
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        td { font-size: 15px; }

        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 18px;
            border-radius: 7px;
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            background: #e5e7eb;
            color: #172b4d;
            font-size: 13px;
        }

        .pagination .current {
            background: #2563eb;
            color: white;
        }

        @media (max-width: 650px) {
            body { padding: 18px 10px; }
            .card { padding: 15px; }
            .search-form { flex-wrap: wrap; }
            .search-form input { flex-basis: 100%; }
            .page-header { align-items: flex-start; }
            h1 { font-size: 24px; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="page-header">
        <div>
            <h1>User Management</h1>
            <p class="subtitle">
                Manage administrator, treasurer, and student accounts.
            </p>
        </div>

        <div class="header-actions">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn secondary">Log out</button>
            </form>

            <a href="{{ route('users.create') }}" class="btn primary">
                + Add User
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('users.index') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Search name, email, or student ID..."
                aria-label="Search users"
            >

            <button type="submit" class="btn primary">Search</button>

            <a href="{{ route('users.index') }}" class="btn secondary">Reset</a>
        </form>
    </div>

    <div class="card">
        <h2 class="section-title">Registered Users</h2>

        <p class="result-count">
            {{ $users->total() }} matching user(s) found.
            @if ($users->total() > 0)
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }}.
            @endif
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->student_id ?: '—' }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            <span class="role-badge">{{ $user->role }}</span>
                        </td>

                        <td>
                            <div class="actions">
                                <a
                                    href="{{ route('users.show', $user->id) }}"
                                    class="btn secondary"
                                >View</a>

                                <a
                                    href="{{ route('users.edit', $user->id) }}"
                                    class="btn primary"
                                >Edit</a>

                                <form
                                    action="{{ route('users.destroy', $user->id) }}"
                                    method="POST"
                                    style="display:inline; margin:0;"
                                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="pagination">
                <div>
                    Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                </div>

                <div>
                    @if ($users->onFirstPage())
                        <span>Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}">Previous</a>
                    @endif

                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if ($page === $users->currentPage())
                            <span class="current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}">Next</a>
                    @else
                        <span>Next</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>
</body>
</html>
