<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
# New Routes Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SlotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'

], function () {
    Route::get('movies', [MovieController::class, 'index']);
    Route::get('movies/{id}', [MovieController::class, 'show']);
    Route::post('movies', [MovieController::class, 'store']);
    Route::post('movies/{id}', [MovieController::class, 'update']);
    Route::delete('movies/{id}', [MovieController::class, 'destroy']);

    Route::get('movies/slots/{id}', [MovieController::class, 'getSlots']);
    Route::post('movies/assign/slot', [MovieController::class, 'assignSlot']);
    Route::post('movies/remove/slot', [MovieController::class, 'removeSlot']);

    Route::get('slots', [SlotController::class, 'index']);
    Route::get('slots/{id}', [SlotController::class, 'show']);
    Route::post('slots', [SlotController::class, 'store']);
    Route::put('slots/{id}', [SlotController::class, 'update']);
    Route::delete('slots/{id}', [SlotController::class, 'destroy']);
});