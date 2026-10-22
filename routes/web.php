<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionPackageBookController;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::middleware(['isLoggedIn'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->middleware(['isAdmin'])->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('book-categories', BookCategoryController::class);
        Route::resource('subscription', SubscriptionController::class);
        Route::get('/subscription/{id}/books', [SubscriptionPackageBookController::class, 'show'])->name('subscription.books');
        Route::post('/subscription/{id}/books', [SubscriptionPackageBookController::class, 'store'])->name('subscription.books.store');

        Route::resource('books', BookController::class);
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('search', [HomeController::class, 'search'])->name('search');

Route::get('/category/{id}', [BookCategoryController::class, 'show'])
    ->name('category.show');

Route::middleware(['isGuest'])->group(function () {
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [UserController::class, 'register'])->name('register.store')->middleware('throttle:5,1');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'login'])->name('login.store')->middleware('throttle:5,1');
});
