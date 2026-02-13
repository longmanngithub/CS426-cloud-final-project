<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminResetPasswordController;

Route::redirect('/', '/admin/login');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Password Reset Routes
Route::get('/admin/forgot-password', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/reset-password/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AdminResetPasswordController::class, 'reset'])->name('admin.password.update');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); 
    Route::get('/manageUser', [AdminController::class, 'manageUser'])->name('admin.manage_users');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.user_detail');
    Route::get('/manageOrganizer', [AdminController::class, 'manageOrganizer'])->name('admin.manage_organizers');
    Route::get('/organizers/{id}', [AdminController::class, 'showOrganizer'])->name('admin.organizer_detail');
    Route::get('/manageEvents', [AdminController::class, 'manageEvents'])->name('admin.manage_events');
    Route::get('/events/{id}', [AdminController::class, 'show'])->name('admin.event_detail');

    Route::post('/users/{id}/toggle-ban', [AdminController::class, 'toggleBanUser'])->name('admin.user.toggle_ban');
    Route::post('/organizers/{id}/toggle-ban', [AdminController::class, 'toggleBanOrganizer'])->name('admin.organizer.toggle_ban');

    Route::delete('/deleteEvent/{id}', [AdminController::class, 'deleteEvent'])->name('admin.event.delete');

    // Admin Profile Routes
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
});
