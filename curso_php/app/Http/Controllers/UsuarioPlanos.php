<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioPlanos extends Controller
{
    // escolher plano
    public function choose(Request $request)
    {
        $request->validate([
            'plano_id' => 'required|exists:planos,id'
        ]);

        $user = $request->user();
        $user->plano_id = $request->plano_id;
        $user->save();

        return response()->json([
            'message' => 'Plano atribuído ao usuário',
            'plan' => $user->plan
        ]);
    }

    // ver plano do usuário
    public function myPlan(Request $request)
    {
        return response()->json(
            $request->user()->plan
        );
    }

    // remover plano do usuário
    public function remove(Request $request)
    {
        $user = $request->user();
        $user->plan_id = null;
        $user->save();

        return response()->json([
            'message' => 'Plano removido'
        ]);
    }
}
