<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/send-otp', [UserApiController::class, 'sendOTP']);
Route::post('/user/verify-otp', [UserApiController::class, 'verifyOTP']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserApiController::class, 'getUserDetails']);
    Route::post('/user/update', [UserApiController::class, 'updateUser']);
});
//   Route::get('/user/fetch', [UserApiController::class, 'getUserDetails']);

Route::post('/user/questionnaire', [UserApiController::class, 'questionnaire']);
Route::post('/user/book-appointment', [UserApiController::class, 'book_appointment']);
Route::get('/get_state', [UserApiController::class, 'get_state']);
Route::get('/get_district', [UserApiController::class, 'get_district']);
Route::post('/create_time_slot', [UserApiController::class, 'create_time_slot']);
// Route::get('/user/check', [UserApiController::class, 'check']);
