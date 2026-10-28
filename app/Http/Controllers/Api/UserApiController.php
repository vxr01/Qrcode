<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserApiController extends Controller
{
    private function authorizeUserManagement(): void
    {
        abort_unless(
            Auth::check() &&
            in_array(Auth::user()->role, [
                'Administrator',
                'Student',
                'Treasurer',
            ], true),
            403,
            'You are not authorized to manage users.'
        );
    }

    public function index(Request $request)
    {
        $this->authorizeUserManagement();

        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'data' => $users,
        ]);
    }

    public function show(User $user)
    {
        $this->authorizeUserManagement();

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => $user->only([
                'id', 'name', 'student_id', 'email',
                'role', 'created_at', 'updated_at',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeUserManagement();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                'unique:users,email',
            ],
            'student_id' => [
                'nullable', 'string', 'max:100',
                'unique:users,student_id',
            ],
            'role' => [
                'required',
                Rule::in(['Administrator', 'Treasurer', 'Student']),
            ],
            'password' => [
                'required', 'confirmed', Password::min(8),
            ],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->student_id = $validated['student_id'] ?? null;
        $user->role = $validated['role'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => $user->only([
                'id', 'name', 'student_id', 'email', 'role',
            ]),
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeUserManagement();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'student_id' => [
                'nullable', 'string', 'max:100',
                Rule::unique('users', 'student_id')->ignore($user->id),
            ],
            'role' => [
                'required',
                Rule::in(['Administrator', 'Treasurer', 'Student']),
            ],
            'password' => [
                'nullable', 'confirmed', Password::min(8),
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->student_id = $validated['student_id'] ?? null;
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $user->only([
                'id', 'name', 'student_id', 'email', 'role',
            ]),
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorizeUserManagement();

        if ((int) $user->id === (int) Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.',
            ], 403);
        }

        if (
            $user->role === 'Administrator' &&
            User::where('role', 'Administrator')->count() <= 1
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete the last Administrator account.',
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
