
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Home page
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Redirect every authenticated user to User Management.
    return redirect()->route('users.index');
})->name('home');

// Login and registration pages
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// User Management CRUD
// All authenticated users can access these routes.
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
});
