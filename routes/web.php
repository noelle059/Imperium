<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController; // Adjust this to your actual controller
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/forgotpass', function () {
    return view('forgotpass');
});

Route::get('/login', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register.store', [RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/confirmpass', function () {
    return view('confirmpass');
});

Route::get('/user/home', function () {
    return view('user.home');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register'); //try nyo magregister muna
Route::post('/register', [RegisteredUserController::class, 'store']); //nastostore na sya 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__ . '/auth.php';

Route::post('/login', [LoginController::class, 'login'])->name('login');

// Modify the login route to check if the user is already authenticated
Route::get('/login', function () {
    if (Auth::check()) {
        // Check if the user is verified
        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('alert', "Please verify your email before accessing the dashboard.");
        }

        // Check if the user is an admin
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')->with('alert', "Already logged in as an admin, logout to use a different account.");
        } else {
            return redirect()->route('user.dashboard')->with('alert', "Already logged in, logout to use a different account.");
        }
    }
    return view('auth.login');
})->name('login');

// User dashboard route
Route::get('/user/dashboard', function () {
    // Check if the user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login')->with('alert', 'You must be logged in to access the user dashboard.');
    }

    if (!Auth::user()->hasVerifiedEmail()) {
        return redirect()->route('verification.notice')->with('alert', "Please verify your email before accessing the dashboard.");
    }

    // If the user is authenticated, return the user dashboard view
    return view('user.dashboard'); // Ensure this view exists
})->name('user.dashboard');


// Admin dashboard route with inline check
Route::get('/admin/dashboard', function () {
    // Check if the user is authenticated and is an admin

    if (!Auth::check()) {
        return redirect()->route('login')->with('alert', 'You must be logged in to access the admin dashboard.');
    }
    
    if (Auth::check() && Auth::user()->is_admin) {
        return view('admin.dashboard'); // Ensure this view exists
    }

    if (!Auth::user()->hasVerifiedEmail()) {
        return redirect()->route('verification.notice')->with('alert', "Please verify your email before accessing the dashboard.");
    }

    // If not an admin, redirect to the user dashboard or show an error
    return redirect()->route('user.dashboard')->with('alert', 'You do not have access to this page.');
})->name('admin.dashboard');

// Google Sign-in
Route::get('auth/google', [GoogleController::class, 'googlePage']); // Corrected method name
Route::get('auth/google/callback', [GoogleController::class, 'googleCallback']); // Corrected method name

Route::get('auth/google/phone', [GoogleController::class, 'showPhoneForm'])->name('google.phone');
Route::post('auth/google/phone', [GoogleController::class, 'storePhone'])->name('google.phone.store');
