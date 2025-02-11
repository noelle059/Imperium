<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController; // Adjust this to your actual controller
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/main', function () {
    return view('main');
});

Route::get('/user/home', function () {
    return view('user.home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/landingpage', function () {
//     return view('landingpage');
// })->middleware(['auth', 'verified'])->name('landingpage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// User dashboard route
Route::get('/user/dashboard', function () {
    return view('user.dashboard'); // Ensure this view exists
})->name('user.dashboard');

// Admin dashboard route with inline check
Route::get('/admin/dashboard', function () {
    // Check if the user is authenticated and is an admin
    if (Auth::check() && Auth::user()->is_admin) {
        return view('admin.dashboard'); // Ensure this view exists
    }

    // If not an admin, redirect to the user dashboard or show an error
    return redirect()->route('user.dashboard')->with('error', 'You do not have access to this page.');
})->name('admin.dashboard');


//Google Sign-in
Route::get('auth/google', [GoogleController::class, 'googlePage']); // Corrected method name
Route::get('auth/google/callback', [GoogleController::class, 'googleCallback']); // Corrected method name

Route::get('auth/google/phone', [GoogleController::class, 'showPhoneForm'])->name('google.phone');
Route::post('auth/google/phone', [GoogleController::class, 'storePhone'])->name('google.phone.store');

