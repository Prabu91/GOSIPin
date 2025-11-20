<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassificationCodeController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JraController;
use App\Http\Controllers\LabelBoxController;
use App\Http\Controllers\UserController;
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

    Route::middleware('check.role')->group(function () {
        Route::resources([
            'users' => UserController::class,
        ]);
        Route::get('classificationCode/create', [ClassificationCodeController::class, 'create'])->name('classificationCode.create');
        Route::post('classificationCode', [ClassificationCodeController::class, 'store'])->name('classificationCode.store');
        Route::get('classificationCode/{classificationCode}/edit', [ClassificationCodeController::class, 'edit'])->name('classificationCode.edit');
        Route::put('classificationCode/{classificationCode}', [ClassificationCodeController::class, 'update'])->name('classificationCode.update');
        Route::delete('classificationCode/{classificationCode}', [ClassificationCodeController::class, 'destroy'])->name('classificationCode.destroy');
    });

    Route::resources([
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

    Route::get('export-data', [LabelBoxController::class, 'exportLabel'])->name('labelBox.exportData');
    Route::get('export-aktif', [ClassificationController::class, 'exportAktif'])->name('classification.exportAktif');
    Route::get('export-inaktif', [ClassificationController::class, 'exportInaktif'])->name('classification.exportInaktif');
    Route::get('export-ba-inaktif', [ClassificationController::class, 'exportBaInaktif'])->name('classification.exportBaInaktif');
    Route::get('export-ba-aktif', [ClassificationController::class, 'exportBaAktif'])->name('classification.exportBaAktif');
    Route::get('export-label/{id}', [LabelBoxController::class, 'exportPdf'])->name('labelBox.export');

    Route::get('import', [ClassificationCodeController::class, 'importView'])->name('classificationCode.importV');
    Route::post('import', [ClassificationCodeController::class, 'import'])->name('classificationCode.import');

    Route::get('import-classification', [ClassificationController::class, 'importClassificationView'])->name('classification.importClassificationView');
    Route::post('import-classification', [ClassificationController::class, 'importClassification'])->name('classification.importClassification');

    Route::put('/classification/bulk-update', [ClassificationController::class, 'bulkUpdateBox'])->name('classification.bulkUpdateBox');


});
