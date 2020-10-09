<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('pedidos', [\App\Http\Controllers\OrderController::class, 'index']);
Route::get('historial/{date?}', [\App\Http\Controllers\OrderController::class, 'getOrdersByDate']);
Route::get('total-ventas/{date?}', [\App\Http\Controllers\OrderController::class, 'getTotalSalesInAday']);

// Route::get('totalPedido/{id}', [\App\Http\Controllers\OrderController::class, 'getTotalOrderPrice']);

Route::post('pedidos', [\App\Http\Controllers\OrderController::class, 'store']);
