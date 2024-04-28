<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'App\Http\Controllers\HomeController@index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['isAdmin'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    //items
    Route::get('items', [App\Http\Controllers\Admin\ItemsController::class, 'index']);

    Route::get('add-items', [App\Http\Controllers\Admin\ItemsController::class, 'create']);

    Route::post('add-items', [App\Http\Controllers\Admin\ItemsController::class, 'store']);

    Route::get('edit-items/{items_id}', [App\Http\Controllers\Admin\ItemsController::class, 'edit']);

    Route::put('update-items/{items_id}', [App\Http\Controllers\Admin\ItemsController::class, 'update']);

    Route::get('delete-items/{items_id}', [App\Http\Controllers\Admin\ItemsController::class, 'destroy']);



    //users
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('edit-user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::put('update-user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'update']);
    Route::get('delete-user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'destroy']);

    Route::get('/users/{user}/summary', [App\Http\Controllers\Admin\UserController::class, 'showUserSummary'])->name('user.summary');
    Route::get('showUserSummary-users/{user}', [App\Http\Controllers\Admin\UserController::class, 'showUserSummary'])->name('admin.user.summary');
    Route::get('/admin/users/{id}/summary', [App\Http\Controllers\Admin\UserController::class, 'userSummary'])->name('admin.users.summary');
});


