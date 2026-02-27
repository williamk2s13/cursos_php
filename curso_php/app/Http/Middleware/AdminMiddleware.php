<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
   public function handle($request, Closure $next)
{
    if (!$request->user() || !$request->user()->isAdmin()) {
        return response()->json([
            'message' => 'Acesso apenas para admin'
        ], 403);
    }

    return $next($request);
}
}
