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

// User creation for testing (remove in production)
Route::get('/create-user', function () {
    User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    return 'User  created!';
});

// User insertion route
Route::post('/insert-user', [UserController::class, 'insertuser'])->name('insert-user');

// Authentication routes with email verification
Auth::routes(['verify' => true]); 

// Dashboard route (requires authentication and email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Email verification routes
Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('verification.resend');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Test email sending route (for debugging)
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('your-test-email@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});

// Home route for authenticated users
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified'])->name('dashboard');