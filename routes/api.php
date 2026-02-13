<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrganizerAuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavEventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminResetPasswordController;

// http://127.0.0.1:8092/api/testAPI
Route::get('/testAPI', function (Request $request) {
    return response()->json([
        "msg" => "API is workingggg...."
    ]);
});



// =====================================================
// --------- USER ROUTES ---------
// =====================================================

Route::prefix('user')->group(function () {
    //http://127.0.0.1:8092/api/user/register
    Route::post('register', [UserAuthController::class, 'register'])->middleware('throttle:10,1');

    //http://127.0.0.1:8092/api/user/login
    Route::post('login', [UserAuthController::class, 'login'])->middleware('throttle:5,1');

    // PROTECTED ROUTES : Token authentication (auth:user)
    Route::middleware(['auth:user', 'token.user'])->group(function () {
        //http://127.0.0.1:8092/api/user/profile
        Route::get('profile', [UserAuthController::class, 'profile']);

        //http://127.0.0.1:8092/api/user/update
        Route::put('update', [UserAuthController::class, 'update']);

        //http://127.0.0.1:8092/api/user/updatePassword
        Route::put('updatePassword', [UserAuthController::class, 'updatePassword']);

        //http://127.0.0.1:8092/api/user/logout
        Route::post('logout', [UserAuthController::class, 'logout']);


        // ------ FAVORITE EVENTS ------- //

        //http://127.0.0.1:8092/api/user/favorites
        //Show all favorite events
        Route::get('favorites', [FavEventController::class, 'index']);

        //http://127.0.0.1:8092/api/user/favorites/add
        //Add favorite event
        Route::post('favorites/add', [FavEventController::class, 'store']);

        //http://127.0.0.1:8092/api/user/favorites/remove/{event_id}
        //Remove favorite event
        Route::delete('favorites/remove/{event_id}', [FavEventController::class, 'destroy']);
    });
});

// --------- END OF USER ROUTES ---------



// =====================================================
// --------- ORGANIZER ROUTES ---------
// =====================================================

Route::prefix('organizer')->group(function () {
    //http://127.0.0.1:8092/api/organizer/register
    Route::post('register', [OrganizerAuthController::class, 'register'])->middleware('throttle:10,1');

    //http://127.0.0.1:8092/api/organizer/login
    Route::post('login', [OrganizerAuthController::class, 'login'])->middleware('throttle:5,1');

    // PROTECTED ROUTES : Token authentication (auth:organizer)
    Route::middleware(['auth:organizer', 'token.organizer'])->group(function () {
        //http://127.0.0.1:8092/api/organizer/profile
        Route::get('profile', [OrganizerAuthController::class, 'profile']);

        //http://127.0.0.1:8092/api/organizer/update
        Route::put('update', [OrganizerAuthController::class, 'update']);

        //http://127.0.0.1:8092/api/organizer/updatePassword
        Route::put('updatePassword', [OrganizerAuthController::class, 'updatePassword']);

        //http://127.0.0.1:8092/api/organizer/logout
        Route::post('logout', [OrganizerAuthController::class, 'logout']);


        // ------ ORGANIZER EVENT MANAGEMENT ------- //

        //http://127.0.0.1:8092/api/organizer/myEvents
        Route::get('myEvents', [EventController::class, 'myEvents']);

        //http://127.0.0.1:8092/api/organizer/store
        Route::post('store', [EventController::class, 'store']);

        //http://127.0.0.1:8092/api/organizer/update/{event_id}
        Route::put('update/{event_id}', [EventController::class, 'update']);

        //http://127.0.0.1:8092/api/organizer/destroy/{event_id}
        Route::delete('destroy/{event_id}', [EventController::class, 'destroy']);
    });
});

// --------- END OF ORGANIZER ROUTES ---------



// =====================================================
// --------- ADMIN ROUTES ---------
// =====================================================

Route::prefix('admin')->group(function () {

    //http://127.0.0.1:8092/api/admin/login
    Route::post('login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');

    //http://127.0.0.1:8092/api/admin/forgot-password
    Route::post('forgot-password', [AdminForgotPasswordController::class, 'sendResetLinkEmail']);

    //http://127.0.0.1:8092/api/admin/reset-password
    Route::post('reset-password', [AdminResetPasswordController::class, 'reset']);

    // PROTECTED ROUTES : Token authentication (auth:admin)
    Route::middleware(['auth:admin', 'token.admin'])->group(function () {
        //http://127.0.0.1:8092/api/admin/dashboard
        Route::get('dashboard', [AdminAuthController::class, 'dashboard']);

        //http://127.0.0.1:8092/api/admin/profile
        Route::get('profile', [AdminAuthController::class, 'profile']);

        //http://127.0.0.1:8092/api/admin/updatePassword
        Route::put('updatePassword', [AdminAuthController::class, 'updatePassword']);

        //http://127.0.0.1:8092/api/admin/logout
        Route::post('logout', [AdminAuthController::class, 'logout']);


        // --------- USER MANAGEMENT ---------

        //http://127.0.0.1:8092/api/admin/manageUser
        Route::get('manageUser', [AdminAuthController::class, 'manageUser']);

        //http://127.0.0.1:8092/api/admin/showUser/{id}
        Route::get('showUser/{id}', [AdminAuthController::class, 'showUser']);

        //http://127.0.0.1:8092/api/admin/toggleBanUser/{id}
        Route::post('toggleBanUser/{id}', [AdminAuthController::class, 'toggleBanUser']);


        // --------- ORGANIZER MANAGEMENT ---------

        //http://127.0.0.1:8092/api/admin/manageOrganizer
        Route::get('manageOrganizer', [AdminAuthController::class, 'manageOrganizer']);

        //http://127.0.0.1:8092/api/admin/showOrganizer/{id}
        Route::get('showOrganizer/{id}', [AdminAuthController::class, 'showOrganizer']);

        //http://127.0.0.1:8092/api/admin/toggleBanOrganizer/{id}
        Route::post('toggleBanOrganizer/{id}', [AdminAuthController::class, 'toggleBanOrganizer']);


        // --------- EVENT MANAGEMENT ---------

        //http://127.0.0.1:8092/api/admin/manageEvent
        Route::get('manageEvent', [AdminAuthController::class, 'manageEvent']);

        //http://127.0.0.1:8092/api/admin/showEvent/{id}
        Route::get('showEvent/{id}', [AdminAuthController::class, 'showEvent']);

        //http://127.0.0.1:8092/api/admin/deleteEvent/{id}
        Route::delete('deleteEvent/{id}', [AdminAuthController::class, 'deleteEvent']);


        // --------- CATEGORY MANAGEMENT ---------

        //http://127.0.0.1:8092/api/admin/category/store
        Route::post('category/store', [CategoryController::class, 'store']);

        //http://127.0.0.1:8092/api/admin/category/update/{id}
        Route::put('category/update/{id}', [CategoryController::class, 'update']);

        //http://127.0.0.1:8092/api/admin/category/destroy/{id}
        Route::delete('category/destroy/{id}', [CategoryController::class, 'destroy']);
    });
});

// --------- END OF ADMIN ROUTES ---------



// =====================================================
// --------- PASSWORD RESET ROUTES (User/Organizer) ---------
// =====================================================

//http://127.0.0.1:8092/api/password/forgot
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);

//http://127.0.0.1:8092/api/password/reset
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// --------- END OF PASSWORD RESET ROUTES ---------



// =====================================================
// --------- CONTACT ROUTES ---------
// =====================================================

//http://127.0.0.1:8092/api/contact/send
Route::post('contact/send', [ContactController::class, 'send']);

// --------- END OF CONTACT ROUTES ---------



// =====================================================
// --------- PUBLIC EVENT ROUTES ---------
// =====================================================

Route::prefix('event')->group(function () {
    //http://127.0.0.1:8092/api/event/index
    //List all events (with optional filters: search, category, price_type, sort)
    Route::get('index', [EventController::class, 'index']);

    //http://127.0.0.1:8092/api/event/show/{id}
    //Show event detail
    Route::get('show/{id}', [EventController::class, 'show']);

    //http://127.0.0.1:8092/api/event/search?q=keyword
    //Search events
    Route::get('search', [EventController::class, 'search']);

    //http://127.0.0.1:8092/api/event/home
    //Home page data (latest events, featured events, categories)
    Route::get('home', [EventController::class, 'homePage']);

    //http://127.0.0.1:8092/api/event/byOrganizer/{organizerId}
    //Events by organizer
    Route::get('byOrganizer/{organizerId}', [EventController::class, 'getEventsByOrganizer']);

    //http://127.0.0.1:8092/api/event/byCategory/{categoryId}
    //Events by category
    Route::get('byCategory/{categoryId}', [EventController::class, 'getEventsByCategory']);
});

// --------- END OF EVENT ROUTES ---------



// =====================================================
// --------- PUBLIC CATEGORY ROUTES ---------
// =====================================================

Route::prefix('category')->group(function () {
    //http://127.0.0.1:8092/api/category/index
    //List all categories
    Route::get('index', [CategoryController::class, 'index']);

    //http://127.0.0.1:8092/api/category/show/{id}
    //Show a category with its events
    Route::get('show/{id}', [CategoryController::class, 'show']);
});

// --------- END OF CATEGORY ROUTES ---------
