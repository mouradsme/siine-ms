<?php 


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersViewer\UserController as UsersViewerUserController;
use App\Http\Controllers\UsersViewer\UserStatusController as UsersViewerUserStatusController;

// Users Viewer MS

Route::prefix('users_viewer')->name('users_viewer.')->group(function () {
    Route::get('/', [UsersViewerUserController::class, 'index'])->name('index');
    Route::get('/users/check-new', [UsersViewerUserController::class, 'checkNewUsers'])->name('check-new'); 
    Route::get('/users/export', [UsersViewerUserController::class, 'export'])->name('export');

    Route::post('/users/update-status', [UsersViewerUserStatusController::class, 'updateStatus'])->name('updateStatus');
});




