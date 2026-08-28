<?php

use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    
    // USER MANAGEMENT ROUTES
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    // PERMISSION MANAGEMENT ROUTES
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [UserPermissionController::class, 'index'])->name('index');
        Route::post('/', [UserPermissionController::class, 'store'])->name('store');
        Route::put('/{permission}', [UserPermissionController::class, 'update'])->name('update');
        Route::delete('/{permission}', [UserPermissionController::class, 'destroy'])->name('destroy');
    });

});