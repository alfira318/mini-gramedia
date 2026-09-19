<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $subscriptions = SubscriptionPackage::take(3)->get();

    return view('home', compact('subscriptions'));
})->name('home');


//kelompok yang boeh diakses hanya setelah login
Route::middleware(['isLoggedIn'])->group(function(){
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    //prefix untuk mengelompokan route admin yang path nya diawli dengan /admin
    //seluruh route pada kelompok ini akan memiliki nama route diawali dangan admin. contoh: admin.dashboard
    Route::prefix('admin')->middleware(['isAdmin'])->name('admin.')->group(function(){
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

    // resource route untuk mengolah data kategori buku yang otomatis membuat sesuai method
    // CRUD pada BookCategoryController
        Route::resource('book-categories', BookCategoryController::class);
    Route::resource('subscription', SubscriptionController::class);
    });

});

//menggunakan get karena adanya proses dulu yaitu menghapus sesi
Route::middleware(['isGuest'])->group(function(){
    Route::get('/register', function () {
    return view('register');
    })->name('register');

    Route::post('/register', [UserController::class, 'register'])->name('register.store')->middleware('throttle:5,1');
    //namacontrollwer, function,

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'login'])->name('login.store')->middleware('throttle:5,1');
});
