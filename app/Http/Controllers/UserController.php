<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Allow authenticated Administrator, Student, and Treasurer
     * accounts to manage users.
     */
    private function authorizeAdmin(): void
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

    /**
     * READ: Display all users and support searching.
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin();

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
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    /**
     * CREATE: Display the Add User form.
     */
    public function create()
    {
        $this->authorizeAdmin();

        return view('users.create');
    }

    /**
     * CREATE: Save a new user.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'student_id' => [
                'nullable',
                'string',
                'max:100',
                'unique:users,student_id',
            ],
            'role' => [
                'required',
                Rule::in(['Administrator', 'Treasurer', 'Student']),
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->student_id = $validated['student_id'] ?? null;
        $user->role = $validated['role'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * READ: Display one user's details.
     */
    public function show(User $user)
    {
        $this->authorizeAdmin();

        return view('users.show', compact('user'));
    }

    /**
     * UPDATE: Display the Edit User form.
     */
    public function edit(User $user)
    {
        $this->authorizeAdmin();

        return view('users.edit', compact('user'));
    }

    /**
     * UPDATE: Save changes to an existing user.
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'student_id' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('users', 'student_id')->ignore($user->id),
            ],
            'role' => [
                'required',
                Rule::in(['Administrator', 'Treasurer', 'Student']),
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8),
            ],
        ]);

        // No self-role restriction:
        // authenticated users can change their own or another user's role.
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->student_id = $validated['student_id'] ?? null;
        $user->role = $validated['role'];

        // Change the password only when a new password is provided.
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * DELETE: Remove a user.
     */
    public function destroy(User $user)
    {
        $this->authorizeAdmin();

        // Preserve the currently logged-in account.
        if ((int) $user->id === (int) Auth::id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Preserve at least one Administrator account.
        if (
            $user->role === 'Administrator' &&
            User::where('role', 'Administrator')->count() <= 1
        ) {
            return redirect()
                ->route('users.index')
                ->with('error', 'You cannot delete the last Administrator account.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
