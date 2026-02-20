<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->admin) {
            return response()->json([
                'message' => 'Acesso permitido apenas para administradores'
            ], 403);
        }

        return $next($request);
    }
}
