<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Authenticate users.
     * All authenticated users go to User Management.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors([
                    'email' => 'The email or password is incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // Administrator, Student, and Treasurer go to User Management.
        return redirect()->route('users.index');
    }

    /**
     * Display the registration page.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Register a new Student account.
     */
    public function register(Request $request)
    {
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

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'student_id' => $validated['student_id'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'Student',
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Registration successful! Please log in using your new account.'
            );
    }

    /**
     * Log out the current user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
