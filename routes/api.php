<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('jobs/search', [App\Http\Controllers\Api\JobsController::class, 'search']);
Route::get('jobs/filter', [App\Http\Controllers\Api\JobsController::class, 'filter']);

Route::apiResource('jobs', App\Http\Controllers\Api\JobsController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 