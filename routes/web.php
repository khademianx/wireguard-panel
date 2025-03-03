<?php

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

Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');

Route::get('c/{client:hash}', ClientQrController::class)->name('qr');

Route::get('dl/{client:hash}', DownloadConfigController::class)->name('download');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
