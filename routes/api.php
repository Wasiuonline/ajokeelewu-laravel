<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SavedItemController;

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

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/home-items', [ItemController::class, 'front_index']);
Route::get('/cat/{cat_slug}', [ItemController::class, 'front_cat']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/users-home-items', [ItemController::class, 'front_index']);
    Route::get('/users-cat/{cat_slug}', [ItemController::class, 'front_cat']);
    Route::get('/save-item/{item_id}', [SavedItemController::class, 'front_save']);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
});

