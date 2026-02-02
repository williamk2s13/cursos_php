<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChoosePlanoRequest;

class UsuarioPlanos extends Controller
{
    public function choose(ChoosePlanoRequest $request)
    {
        $user = $request->user();
        $user->escolherPlano($request->plano_id);

        return response()->json([
            'message' => 'Plano atribuído ao usuário',
            'plan' => $user->plan
        ]);
    }

    public function myPlan(Request $request)
    {
        return response()->json(
            $request->user()->plan
        );
    }

    public function remove(Request $request)
    {
        $user = $request->user();
        $user->removerPlano();

        return response()->json([
            'message' => 'Plano removido'
        ]);
    }
}


