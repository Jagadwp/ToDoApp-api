<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'sections'], function () {
    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('', [SectionController::class, 'store']);
        Route::get('', [SectionController::class, 'index']);
        Route::get('/checklists', [SectionController::class, 'getAllWithChecklist']);
        Route::get('/checklists/{id}', [SectionController::class, 'getByIdWithChecklist']);
        Route::get('/{id}', [SectionController::class, 'show']);
        Route::put('/{id}', [SectionController::class, 'update']);
        Route::delete('/{id}', [SectionController::class, 'destroy']);   
    });
});

Route::group(['prefix' => 'checklists'], function () {
    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('', [ChecklistController::class, 'index']);
        Route::get('/{id}', [ChecklistController::class, 'show']);
        Route::post('', [ChecklistController::class, 'store']);
        Route::put('/{id}', [ChecklistController::class, 'update']);
        Route::delete('/{id}', [ChecklistController::class, 'destroy']);   
    });
});