<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Models\Warehouse;
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

/** PUBLIC ROUTES */
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

/** PROTECTED ROUTES */
Route::group([
    'prefix' => 'auth',
    'middleware' => ['auth:sanctum', 'can:' . AuthorizedPages::USERS],
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
});
Route::group([
    'prefix' => 'auth',
    'middleware' => ['auth:sanctum'],
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('/accessing', [AuthController::class, 'accessing']);
});

Route::group([
    'prefix' => 'users',
    'middleware' => ['auth:sanctum', 'can:' . AuthorizedPages::USERS],
], function ($router) {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
});


Route::group([
    'prefix' => 'warehouses',
    'middleware' => ['auth:sanctum', 'can:' . AuthorizedPages::WAREHOUSES],
], function ($router) {
    Route::get('/', [WarehouseController::class, 'index']);
    Route::get('/{warehouse}', [WarehouseController::class, 'show']);
    Route::post('/', [WarehouseController::class, 'store']);
    Route::put('/{warehouse}', [WarehouseController::class, 'update']);
    Route::delete('/{warehouse}', [WarehouseController::class, 'destroy']);
});