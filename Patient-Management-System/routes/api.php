<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
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




// changes - update naming convention
Route::Post('login', [AuthController::class, 'login']);
Route::Post('register', [AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('viewappointment', [AppointmentController::class, 'viewAppointment']);
        Route::post('reject', [AppointmentController::class, 'rejectAppointment']);
        Route::post('accept', [AppointmentController::class, 'acceptAppointment']);
    });

    Route::get('bookappointment', [AppointmentController::class, 'bookAppointment']);
    Route::get('doctorlist', [DoctorController::class, 'doctorList']);
    Route::get('invoice', [PaymentController::class, 'payInvoice']);
});
Route::post('webhook', [PaymentController::class, 'webhookCAll']);
