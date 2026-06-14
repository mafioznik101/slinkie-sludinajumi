<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('posts.index'));

// Language Switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Posts
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
Route::resource('posts', PostController::class)->middlewareFor(
    ['create', 'store', 'edit', 'update', 'destroy'],
    'auth'
);

// Comments
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Profiles
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Reviews
Route::middleware('auth')->group(function () {
    Route::post('/users/{user}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/users/{user}/block', [AdminController::class, 'blockUser'])->name('blockUser');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('destroyUser');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('destroyPost');
});