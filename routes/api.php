<?php

use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('pasien')->group(function () {
    Route::get('/', [PatientController::class, 'index']);
    // Route::post('/', [PatientController::class, 'store']);
    // Route::get('/{id}', [PatientController::class, 'show']);
    // Route::put('/{id}', [PatientController::class, 'update']);
    // Route::delete('/{id}', [PatientController::class, 'destroy']);
});
