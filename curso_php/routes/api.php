<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioPlanos;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\CursoSalvoController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\AvaliacaoController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/cadastro', [LoginController::class, 'register']);


Route::middleware('auth:sanctum')->get('/perfil', [UserController::class, 'perfil']);


Route::put('/usuarios/{id}', [UserController::class, 'update']);

Route::get('/planos', [PlanController::class, 'index']);


Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/planos', [PlanController::class, 'adminIndex']);
    Route::post('/planos', [PlanController::class, 'store']);
   Route::patch('/admin/planos/toggle-grupo', [PlanController::class, 'toggleGrupo']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/usuario/plano', [UsuarioPlanos::class, 'choose']);
    Route::get('/usuario/plano', [UsuarioPlanos::class, 'myPlan']);
    Route::delete('/usuario/plano', [UsuarioPlanos::class, 'remove']);
});

Route::get('/cursos', [CursoController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cursos/{curso}', [CursoController::class, 'show']);
});
Route::middleware('auth:sanctum')->get('/aulas/{aula}', [AulaController::class, 'show']);

Route::middleware(['auth:sanctum', 'professor', 'admin'])->group(function () {
    Route::post('/cursos', [CursoController::class, 'store']);
    Route::post('/modulos', [ModuloController::class, 'store']);
    Route::post('/aulas', [AulaController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cursos/{curso}/salvar', [CursoSalvoController::class, 'toggle']);
    Route::get('/meus-cursos-salvos', [CursoSalvoController::class, 'index']);
    Route::get('/cursos/{id}/salvo', [CursoSalvoController::class, 'verificarSalvo']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/users', [UserAdminController::class, 'index']);
    Route::patch(
        '/admin/users/{id}/toggle-professor',
        [UserAdminController::class, 'toggleProfessor']
    );

});

Route::middleware(['auth:sanctum', 'professor'])->group(function () {
    Route::get('/meus-cursos', [CursoController::class, 'meusCursos']);
    Route::post('/cursos', [CursoController::class, 'store']);
    Route::post('/modulos', [ModuloController::class, 'store']);
    Route::post('/aulas', [AulaController::class, 'store']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/aulas/{aula}/concluir', [AulaController::class, 'concluir']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cursos/{id}/avaliar', [AvaliacaoController::class, 'avaliar']);
});