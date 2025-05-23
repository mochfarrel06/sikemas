<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\QueueController;
use App\Http\Controllers\Api\QueueHistoryController;
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

Route::post('/register', [AuthController::class, 'register']);

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('pasien')->group(function () {
    Route::get('/', [PatientController::class, 'index']);
    Route::post('/', [PatientController::class, 'store']);
    Route::get('/{id}', [PatientController::class, 'show']);
    Route::put('/update', [PatientController::class, 'update']);
    Route::delete('/{id}', [PatientController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('queue')->group(function() {
    Route::get('/', [QueueController::class, 'index']);
    Route::post('/', [QueueController::class, 'store']);
    Route::get('/history', [QueueController::class, 'show_history']);
});

Route::middleware('auth:sanctum')->prefix('dokter')->group(function () {
    Route::get('/', [QueueController::class, 'show_dokter']);
    Route::get('/poli', [QueueController::class, 'show_poli']);
    Route::get('/poli/{id}', [QueueController::class, 'show_dokter_by_poli']);
    Route::get('/jadwal_dokter/{doctor_id}/{date}', [QueueController::class, 'getDoctorSchedule']);
});
