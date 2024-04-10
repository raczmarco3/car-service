<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ServicesController;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/check-database', [GeneralController::class, 'checkDatabase']);
Route::get('/clients', [ClientsController::class, 'getClients']);
Route::get('/client/{clientId}/cars', [CarsController::class, 'getClientCars']);
Route::get('/services', [ServicesController::class, 'getServiceLogs']);
Route::get('/client', [ClientsController::class, 'findClient']);
