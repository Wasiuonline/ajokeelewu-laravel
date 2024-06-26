<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\NewsletterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::post("/newsletter", [NewsletterController::class, "store"]);
Route::post("/contact", [ContactController::class, "store"]);
Route::post("/search", [ItemController::class, "front_search"]);

require __DIR__.'/auth.php';
