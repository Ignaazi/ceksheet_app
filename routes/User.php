<?php

// Import Controller dari sub-folder Admin
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    
    /* USER MANAGEMENT ROUTES (Admin Domain) */
    Route::prefix('users')->name('users.')->group(function () {
        // Hanya bisa diakses jika role punya permission 'view-users'
        Route::get('/', [UserManagementController::class, 'index'])
            ->middleware('can:view-users')
            ->name('index');

        // Hanya bisa diakses jika role punya permission 'create-users'
        Route::get('/create', [UserManagementController::class, 'create'])
            ->middleware('can:create-users')
            ->name('create');

        Route::post('/', [UserManagementController::class, 'store'])
            ->middleware('can:create-users')
            ->name('store');

        // Hanya bisa diakses jika role punya permission 'edit-users'
        Route::put('/{user}', [UserManagementController::class, 'update'])
            ->middleware('can:edit-users')
            ->name('update');

        // Hanya bisa diakses jika role punya permission 'delete-users'
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])
            ->middleware('can:delete-users')
            ->name('destroy');
    });

    /* PERMISSION MANAGEMENT ROUTES */
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [UserPermissionController::class, 'index'])->name('index');
        Route::post('/', [UserPermissionController::class, 'store'])->name('store');
        Route::put('/', [UserPermissionController::class, 'update'])->name('update');
        Route::delete('/{permission}', [UserPermissionController::class, 'destroy'])->name('destroy');
    });

});