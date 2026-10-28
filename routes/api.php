
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;

Route::prefix('users')->middleware(['web', 'auth'])->group(function () {
    // Display all users and search users
    Route::get('/', [UserApiController::class, 'index']);

    // Create a new user
    Route::post('/', [UserApiController::class, 'store']);

    // Display one user
    Route::get('/{user}', [UserApiController::class, 'show']);

    // Update an existing user
    Route::put('/{user}', [UserApiController::class, 'update']);
    Route::patch('/{user}', [UserApiController::class, 'update']);

    // Delete a user
    Route::delete('/{user}', [UserApiController::class, 'destroy']);
});
