<?php

use Illuminate\Support\Facades\Route;


use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page with dynamic events and categories
Route::get('/', [EventController::class, 'homePage']);

// Event browsing (public)
Route::get('/events', [EventController::class, 'eventsPage'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Static pages
Route::get('/aboutus', function () {
    return view('info.aboutus');
});
Route::get('/contact', function () {
    return view('info.contactus');
});


// Password Reset Routes
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Auth pages (public)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/user_signup', function () {
    return view('auth.user_signup');
});
Route::get('/org_signup', function () {
    return view('auth.org_signup');
});
Route::get('/userororg', function () {
    return view('auth.userororg');
});

// Authentication actions (rate-limited)
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/organizer/register', [OrganizerController::class, 'registerOrganizer']);
    Route::post('/organizer/login', [AuthController::class, 'loginOrganizer']);
});
Route::post('/logout', [AuthController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| User Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth.user')->group(function () {
    // User pages
    // Route::get('/userhome', [UserController::class, 'userHome']);
    Route::get('/userpf', [UserController::class, 'userProfile']);
    Route::put('/userpf', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::put('/user/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::get('/userfav', [UserController::class, 'userFav']);
    
    // Favorite events
    Route::post('/favorite-events/add', [FavoriteEventController::class, 'store'])->name('favorite-events.add');
    Route::post('/favorite-events/remove', [FavoriteEventController::class, 'destroy'])->name('favorite-events.remove');
});


/*
|--------------------------------------------------------------------------
| Organizer Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth.organizer')->group(function () {
    // Organizer pages
    // Route::get('/orghome', [OrganizerController::class, 'orgHome']);
    Route::get('/orgpf', [OrganizerController::class, 'orgProfile']);
    Route::put('/orgpf', [OrganizerController::class, 'updateProfile'])->name('organizer.updateProfile');
    Route::put('/organizer/password', [OrganizerController::class, 'updatePassword'])->name('organizer.updatePassword');
    Route::get('/orgmyevents', [OrganizerController::class, 'myEvents']);
    Route::get('/orgpostevents', function () {
        return view('org.orgpostevents');
    });
    
    // Event management
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});


/*
|--------------------------------------------------------------------------
| Legacy/Utility Routes
|--------------------------------------------------------------------------
*/

// Remove or redirect old routes
Route::redirect('/eventsinfo', '/events');

Route::get('/header', function () {
    return view('header');
});

// Event report placeholder
Route::get('/events/{id}/report', function($id) { return 'Report event ' . $id; });
Route::post('/contactus/send', [ContactController::class, 'send']);
