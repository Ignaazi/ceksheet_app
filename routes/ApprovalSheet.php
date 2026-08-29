<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalSheetController;

Route::middleware('auth')->prefix('approval-sheets')->name('approval.')->group(function () {
    // Tampilan Utama & Pembuatan Sheet
    Route::get('/', [ApprovalSheetController::class, 'index'])->name('index');
    Route::get('/create', [ApprovalSheetController::class, 'create'])->name('create');
    Route::post('/store', [ApprovalSheetController::class, 'store'])->name('store');
    
    // Detail & Print Preview Approval Form
    Route::get('/{id}', [ApprovalSheetController::class, 'show'])->name('show');
    Route::get('/{id}/print', [ApprovalSheetController::class, 'print'])->name('print');
    
    // Route Aksi Status Approval
    Route::patch('/{id}/approve', [ApprovalSheetController::class, 'approve'])->name('approve');
    Route::patch('/{id}/reject', [ApprovalSheetController::class, 'reject'])->name('reject');
});