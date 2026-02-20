<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ChoosePlanoRequest;
use App\Models\PlanoHistorico;
use App\Models\UsuarioUsoPlano;
use Carbon\Carbon;

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

            $hoje = Carbon::today(config('app.timezone'))->toDateString();
            UsuarioUsoPlano::firstOrCreate(
                [
                    'usuario_id' => $user->id,
                    'data_controle' => $hoje
                ],
                [
                    'aulas_usadas_dia' => 0
                ]
            );

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
