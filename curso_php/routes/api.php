<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/cadastro', [LoginController::class, 'register']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return $request->user();
    });
});

Route::put('/usuarios/{id}', [UserController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/planos', [PlanController::class, 'index']);
    Route::post('/planos', [PlanController::class, 'store']);
    Route::delete('/planos/{id}', [PlanController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/usuario/plano', [UsuarioPlanos::class, 'choose']);
    Route::get('/usuario/plano', [UsuarioPlanos::class, 'myPlan']);
    Route::delete('/usuario/plano', [UsuarioPlanos::class, 'remove']);
});