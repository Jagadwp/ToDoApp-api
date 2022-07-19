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
        Route::get('/checklists/{section_id}', [SectionController::class, 'getByIdWithChecklist']);
        Route::get('/{section_id}', [SectionController::class, 'show']);
        Route::put('/{section_id}', [SectionController::class, 'update']);
        Route::delete('/{section_id}', [SectionController::class, 'destroy']);   

        Route::get('/{section_id}/checklists', [ChecklistController::class, 'index']);
        Route::get('/{section_id}/checklists/{checklist_id}', [ChecklistController::class, 'show']);
        Route::post('/{section_id}/checklists', [ChecklistController::class, 'store']);
        Route::put('/{section_id}/checklists/{checklist_id}', [ChecklistController::class, 'update']);
        Route::delete('/{section_id}/checklists/{checklist_id}', [ChecklistController::class, 'destroy']);   
    });
});
