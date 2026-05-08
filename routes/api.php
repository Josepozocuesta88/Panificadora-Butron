<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderEmailFromAppController;
use App\Http\Controllers\ToolsController;

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

Route::get('/send-order-email-from-app/{pedidoId}', [OrderEmailFromAppController::class, 'sendOrderEmailFromApp']);

// Ruta para obtener los correos electrónicos de un usuario
Route::get('/users/{userId}/emails', [ToolsController::class, 'emailsForUser']);
