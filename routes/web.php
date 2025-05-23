<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientQrController;
use App\Http\Controllers\DownloadConfigController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('admins', AdminController::class)->only(['index', 'store', 'destroy']);

    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::get('/clients/{client}/update', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}/update', [\App\Http\Controllers\Api\ClientController::class, 'update'])->name('client.update');

    Route::get('/backup', [BackupController::class, 'create'])->name('backup.create');
    Route::post('/backup', [BackupController::class, 'import'])->name('backup.import');
});

Route::get('c/{client:hash}', ClientQrController::class)->name('qr');
Route::get('dl/{client:hash}', DownloadConfigController::class)->name('download');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
