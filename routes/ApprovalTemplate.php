<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalTemplateController;

Route::middleware(['web', 'auth'])->group(function () {
    
    // Route khusus untuk Preview Blade Template (approvalCanvas)
    Route::get('approval-templates/{id}/preview', [ApprovalTemplateController::class, 'preview'])
        ->name('approval-templates.preview');

    // Resource Route untuk fungsi CRUD (index, store, show, update, destroy)
    Route::resource('approval-templates', ApprovalTemplateController::class);

});