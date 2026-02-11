<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ChoosePlanoRequest;
use App\Models\PlanoHistorico;

class UsuarioPlanos extends Controller
{
    public function choose(ChoosePlanoRequest $request)
{
    return DB::transaction(function () use ($request) {

        $user = $request->user();

        $user->escolherPlano($request->plano_id);

        PlanoHistorico::create([
            'usuario_id' => $user->id,
            'plano_id'   => $request->plano_id,
        ]);

        $user->refresh()->load('plano');

        return response()->json([
            'message' => 'Plano atribuído ao usuário',
            'usuario' => $user
        ]);
    });
}

    public function myPlan(Request $request)
    {
        return response()->json(
            $request->user()->plano_id
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


