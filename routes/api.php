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

Route::get('admin/pedidos', [\App\Http\Controllers\OrderController::class, 'index']);
Route::get('admin/historial/{date?}', [\App\Http\Controllers\OrderController::class, 'getOrdersByDate']);
Route::get('admin/total-ventas/{date?}', [\App\Http\Controllers\OrderController::class, 'getTotalSalesInAday']);
Route::post('admin/pedidos', [\App\Http\Controllers\OrderController::class, 'store']);
