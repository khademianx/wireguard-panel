<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(
    function () {
        Route::apiResource('clients', ClientController::class)->middleware(HandlePrecognitiveRequests::class);
    }
);
