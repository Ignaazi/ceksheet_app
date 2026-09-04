<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalTemplateController; // Sesuaikan dengan controller kamu

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/approval-templates', [ApprovalTemplateController::class, 'index'])->name('approval-templates.index');
});