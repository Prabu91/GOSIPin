<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassificationCodeController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JraController;
use App\Http\Controllers\LabelBoxController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'users' => UserController::class,
        'classificationCode' => ClassificationCodeController::class,
        'classification' => ClassificationController::class,
        'labelBox' => LabelBoxController::class,
    ]);

    Route::get('active', [ClassificationController::class, 'indexActive'])->name('classification.active');
    Route::get('inactive', [ClassificationController::class, 'indexInactive'])->name('classification.inactive');
    Route::get('classificationBox/edit/{id}', [ClassificationController::class, 'editBox'])->name('classification.editBox');
    Route::put('classificationBox/{id}', [ClassificationController::class, 'updateBox'])->name('classification.updateBox');
    Route::get('editRak/edit/{id}', [LabelBoxController::class, 'editRak'])->name('labelBox.editRak');
    Route::put('editRak/{id}', [LabelBoxController::class, 'updateRak'])->name('labelBox.updateRak');
    Route::get('export-label/{id}', [LabelBoxController::class, 'exportPdf'])->name('labelBox.export');



    Route::get('import', [ClassificationCodeController::class, 'importView'])->name('classificationCode.importV');
    Route::post('import', [ClassificationCodeController::class, 'import'])->name('classification.import');

});
