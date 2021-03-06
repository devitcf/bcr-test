<?php

use App\Http\Controllers\DrinkController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('drink')->group(function (){
    Route::get('list', [DrinkController::class, 'list']);
    Route::get('limit/get', [DrinkController::class, 'getLimit']);
    Route::post('calculate', [DrinkController::class, 'calculate']);
});
