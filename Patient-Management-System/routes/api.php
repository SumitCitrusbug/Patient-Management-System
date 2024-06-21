<?php

use App\Http\Controllers\DocterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['auth:api'])->group(function () {
});

Route::Post('login', [UserController::class, 'login']);
Route::Post('register', [UserController::class, 'register']);
Route::get('docterlist', [DocterController::class, 'docterList']);
Route::Post('bookappointment', [UserController::class, 'bookAppointment']);
Route::Post('viewappointment', [UserController::class, 'viewtAppointment']);
Route::Post('reject/{appointment_id}', [UserController::class, 'rejectAppointment']);
Route::Post('accept/{appointment_id}', [UserController::class, 'acceptAppointment']);
Route::Post('makepayment/{appointment_id}', [UserController::class, 'makePayment']);
