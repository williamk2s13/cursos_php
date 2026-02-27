<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfessorMiddleware
{
 public function handle(Request $request, Closure $next)
{
    if (
        !$request->user() ||
        !in_array($request->user()->role, ['professor', 'admin'])
    ) {
        return response()->json([
            'message' => 'Apenas professores ou administradores podem acessar'
        ], 403);
    }

    return $next($request);
}
}