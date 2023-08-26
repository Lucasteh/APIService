<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Public\GameListController;
use App\Http\Controllers\Public\LotteryTicketTransactionController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/game-list',[GameListController::class,'GetGameList']);
    Route::post('/create-lottery-transaction', [LotteryTicketTransactionController::class,'CreateLotteryTicket']);
});

// Route::get('/get-lottery-transaction-list', [LotteryTicketTransactionController::class,'GetTransactionList']);

// Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

