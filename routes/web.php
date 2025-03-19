<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DashboardController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
//notification
use App\Http\Controllers\NotificationController;
// CLASSROOM
use App\Http\Controllers\ClassroomController;
// FLOOR
use App\Http\Controllers\FloorController;
// SUBJECT
use App\Http\Controllers\SubjectController;
//  ROOM AND DEVICE
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ScheduleController;
use App\Models\Room;
use App\Models\User;
use App\Models\Schedule;

Route::get('/', function () {
    return view('homepage', ['alert' => session('alert')]);
})->name('home');


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
    return redirect()->route('user.dashboard');
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
Route::get('/user/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('user.dashboard');

Route::get('/get-room-status', [DashboardController::class, 'getRoomStatus']);
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


Route::post('/handle-rfid-scan', [DashboardController::class, 'handleRfidScan'])
    ->middleware('auth')
    ->name('handle.rfid.scan');

// Route::get('/get-rooms', [DashboardController::class, 'getRooms'])
// ->middleware('auth')
// ->name('get.rooms');



Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'softDelete'])->name('notifications.destroy');
});








// USER DASHBOAR

Route::post('/add-device', [DeviceController::class, 'addDevice']);
Route::get('/get-devices/{classroomId}', [DeviceController::class, 'getDevices']);






// ADMIN SIDE


// Dashboard Controller
Route::get('/admin/dashboard', [AdminDashboardController::class, 'showAdminDashboard'])->name('admin.dashboard');





// Round in the Professor Account
Route::get('/admin/professor-accounts', [AdminController::class, 'showProfessors'])->name('accounts');
Route::get('/fetch-rfid', [AdminController::class, 'fetchRFID'])->name('fetch.rfid');

// Round in the Professor Account
Route::get('/admin/admin-accounts', [AdminController::class, 'showAdminAccount'])->name('show_admin_accounts');



// Update Professors Account No
Route::put('admin/accounts/{id}', [AdminController::class, 'update'])->name('accounts.update');
// Archive a account
Route::patch('admin/accounts/remove/{id}', [AdminController::class, 'remove'])->name('accounts.remove');


// Admin dashboard Subject Route
Route::resource('/admin/subjects', SubjectController::class);
// Update a subject
Route::put('admin/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
// Archive a subject
Route::patch('admin/subjects/remove/{id}', [SubjectController::class, 'remove'])->name('subjects.remove');


// Show Devices
Route::get('/admin/show-devices', [DeviceController::class, 'showAddDevices'])->name('show_devices');
// Add Devices
Route::post('/admin/add-devices', [DeviceController::class, 'addDevice'])->name('admin.addDevices');
// Update dvice
Route::put('admin/update-device/{id}', [DeviceController::class, 'update'])->name('devices.update');
// Archive device
Route::patch('admin/device/remove/{id}', [DeviceController::class, 'remove'])->name('device.remove');


// Show Floor
Route::get('/admin/floor', [FloorController::class, 'showFloor'])->name('show_floor');
// Add Floor
Route::post('/admin/add-floor-level', [FloorController::class, 'addFloor'])->name('add_floor_level');
// Update Floor
Route::put('/admin/floor/{id}', [FloorController::class, 'updateFloor'])->name('floor.update');
// Archive Floor
Route::patch('admin/floor/remove/{id}', [FloorController::class, 'removeFloor'])->name('floor.remove');


// Route to show classrooms (with plural form)
Route::get('/admin/classrooms', [ClassroomController::class, 'showClassroom'])->name('show_classroom');
// Route to handle classroom creation (add classroom)
Route::post('/admin/add-classroom', [ClassroomController::class, 'addClassroom'])->name('add_classroom');
// Update Classroom
Route::put('admin/update-classroom/{id}', [ClassroomController::class, 'updateClassroom'])->name('update_classroom');
// Archive Classroom
Route::patch('admin/classroom/remove/{id}', [ClassroomController::class, 'removeClassroom'])->name('classroom_remove');


// Route to show Schedules (with plural form)
Route::get('/admin/schedules', [ScheduleController::class, 'showSchedule'])->name('show_schedule');
// Route to handle schedule creation (add classroom)
Route::post('/admin/add-schedule', [ScheduleController::class, 'addSchedule'])->name('add_schedule');
// Update Schedule
Route::put('admin/update-schedule/{id}', [ScheduleController::class, 'updateSchedule'])->name('update_schedule');
// Archive Schedule
Route::patch('admin/schedule/remove/{id}', [ScheduleController::class, 'removeSchedule'])->name('remove_schedule');

// Route to get all schedules (calendar)
Route::get('/get-schedules', [ScheduleController::class, 'getSchedules']);


// Route to show Archive (with plural form)
Route::get('/admin/archive/accounts', [ArchiveController::class, 'showArchiveAccount'])->name('show_archive_account');







Route::get('/admin/classroom', function () {
    $rooms = Room::leftJoin('users', 'rooms.professor_name', '=', 'users.name')
        ->select('rooms.*', 'users.rfid_uid as account_no')
        ->get();

    return view('admin.classroom', compact('rooms'));
})->name('classroom');



// slider route
use App\Http\Controllers\SliderController;

// Route to display the slider management page
Route::get('/admin/slider', [SliderController::class, 'index'])->name('admin.slider.sliderchanger');

Route::get('/carousel', [SliderController::class, 'carousel'])->name('carousel');

Route::get('/', [SliderController::class, 'homepage'])->name('home'); // Homepage


// Route to store a new slider image
Route::post('/admin/slider', [SliderController::class, 'store'])->name('admin.slider.store');

// Route to soft delete a slider image
Route::delete('/admin/slider/{id}', [SliderController::class, 'destroy'])->name('admin.slider.destroy');









//feedback
use App\Http\Controllers\FeedbackController;

Route::get('/', [FeedbackController::class, 'homepage'])->name('home');

// Admin Feedback Management Routes (Similar to Slider)
Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.feedbackchanger');
Route::post('/admin/feedback', [FeedbackController::class, 'store'])->name('admin.feedback.store'); // Store New Feedback
Route::delete('/admin/feedback/{id}', [FeedbackController::class, 'destroy'])->name('admin.feedback.destroy'); // Delete Feedback
Route::get('/admin/feedback/edit/{id}', [FeedbackController::class, 'edit'])->name('admin.feedback.edit'); // Edit Feedback Page
Route::put('/admin/feedback/{id}', [FeedbackController::class, 'update'])->name('admin.feedback.update'); // Update Feedback






//footer
use App\Http\Controllers\FooterController;

Route::get('/admin/footer', [FooterController::class, 'index'])->name('admin.footer.index');
Route::put('/admin/footer', [FooterController::class, 'update'])->name('admin.footer.update');

//about us
use App\Http\Controllers\AboutUsController;

Route::get('/admin/about', [AboutUsController::class, 'index'])->name('admin.about.index');
Route::put('/admin/about', [AboutUsController::class, 'update'])->name('admin.about.update');

//phone number
use App\Http\Controllers\PhoneVerificationController;

// Phone verification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/auth/verify-phone', function () {
        return view('auth.verify-phone'); // Make sure this matches your file name
    })->name('auth.verify-phone.view');

    Route::post('/auth/verify-phone/send-otp', [PhoneVerificationController::class, 'sendOtp'])->name('auth.verify-phone.sendOtp');
    Route::post('/auth/verify-phone', [PhoneVerificationController::class, 'verifyOtp'])->name('auth.verify-phone.verifyOtp');
});

//classroom
Route::get('/admin/reports/classrooms', function () {
    return view('admin.classroom_report');
})->name('report.classroom');

Route::get('/admin/reports/classrooms', [ClassroomController::class, 'classroomReport'])->name('report.classroom');
Route::get('/admin/classrooms/print/{id}', [ClassroomController::class, 'printPdf'])->name('classrooms.print');

Route::get('/admin/classrooms/print-all', [ClassroomController::class, 'printAll'])->name('classrooms.printAll');



//davac

