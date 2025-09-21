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
    Route::post('/user/update_profile', [UserApiController::class, 'update_profile']);
    Route::post('/user/get_profile_pic', [UserApiController::class, 'get_profile_pic']);
    Route::post('/add_time_slot', [UserApiController::class, 'add_time_slot']);
    Route::post('/user/book-appointment', [UserApiController::class, 'book_appointments']);
});
Route::post('/user/upload-report', [UserApiController::class, 'upload_report']);
Route::post('/get_time_slot', [UserApiController::class, 'get_time_slot']);
// Route::get('/user/fetch', [UserApiController::class, 'getUserDetails']);

Route::post('/user/questionnaire', [UserApiController::class, 'questionnaire']);

Route::post('/user/book_teleconsultation', [UserApiController::class, 'book_teleconsultation']);
Route::get('/user/get_book_teleconsultation', [UserApiController::class, 'get_book_teleconsultation']);
Route::get('/get_state', [UserApiController::class, 'get_state']);
Route::get('/get_district', [UserApiController::class, 'get_district']);
Route::post('/testing_center', [UserApiController::class, 'testing_center']);
Route::get('/get_questionaire', [UserApiController::class, 'get_questionaire']);
Route::get('/get_notifications', [UserApiController::class, 'get_notifications']);
Route::get('/get_vns_list', [UserApiController::class, 'get_vns_list']);
Route::get('/get_announcement', [UserApiController::class, 'get_announcement']);
Route::get('/get_service_type', [UserApiController::class, 'get_service_type']);
Route::get('/get_doctor', [UserApiController::class, 'get_doctor']);
Route::get('/user/centers/{stateId}', [AppointmentController::class, 'getCentersByState']);
// Route::get('/user/check', [UserApiController::class, 'check']);
