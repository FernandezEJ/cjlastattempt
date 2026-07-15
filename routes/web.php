<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ======================
// PUBLIC HOMEPAGE
// ======================
Route::get('/', [BlogController::class, 'home'])
    ->name('home');

// ======================
// PUBLIC BLOG VIEW
// ======================
Route::get('/blogs/{blog}/view', [BlogController::class, 'show'])
    ->name('blogs.show');

// ======================
// DASHBOARD
// ======================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

// ======================
// ADMIN AND AUTHOR ONLY
// ======================
Route::middleware(['auth', 'role:admin|author'])->group(function () {

    Route::get('/blogs', [BlogController::class, 'index'])
        ->name('blogs.index');

    Route::get('/blogs/create', [BlogController::class, 'create'])
        ->name('blogs.create');

    Route::post('/blogs', [BlogController::class, 'store'])
        ->name('blogs.store');

    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])
        ->name('blogs.edit');

    Route::put('/blogs/{blog}', [BlogController::class, 'update'])
        ->name('blogs.update');

    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])
        ->name('blogs.destroy');
});

// ======================
// ADMIN ONLY
// ======================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::patch('/blogs/{blog}/approve', [BlogController::class, 'approve'])
        ->name('blogs.approve');

    Route::patch('/blogs/{blog}/reject', [BlogController::class, 'reject'])
        ->name('blogs.reject');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('users.updateRole');
});

// ======================
// PROFILE
// ======================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';