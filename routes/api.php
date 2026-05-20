<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ATMController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', function () {
    return response()->json([
        'message' => 'ATM API works'
   ]);
});

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/withdraw', [ATMController::class, 'withdraw']);
});

Route::delete('/transactions/{id}', [ATMController::class, 'deleteTransaction']);
