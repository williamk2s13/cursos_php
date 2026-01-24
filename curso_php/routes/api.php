<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\assinatura;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/cadastro', [LoginController::class, 'register']);


Route::middleware('auth:sanctum')->get('/perfil', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
Route::post('/assinatura', [assinatura::class, 'choose']);
Route::get('/assinatura', [assinatura::class, 'show']);
Route::delete('/assinatura', [assinatura::class, 'remove']);
});