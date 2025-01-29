<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Home route
Route::get('/', [HomeController::class, 'showMessage']);

// Static pages
Route::get('/n', function () {
    return view('noelle');
});

Route::get('/contact', function () {
    return view('contact');
});


// User insertion route
Route::post('/insert-user', [UserController::class, 'insertuser'])->name('insert-user');

// Authentication routes with email verification
Auth::routes(['verify' => true]); 


// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Home route for authenticated users
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified'])->name('dashboard');