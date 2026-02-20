<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use App\Http\Requests\StorePlanoRequest;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(
            Plano::with('beneficios')
                ->where('status', true)
                ->get()
        );
    }

    public function adminIndex()
    {
        return response()->json(
            Plano::with('beneficios')->get()
        );
    }

    public function store(StorePlanoRequest $request)
{
    return DB::transaction(function () use ($request) {

        $data = $request->validated();

        $planoMensal = Plano::create([
            'nome' => $data['nome'] . ' Mensal',
            'preco' => $data['preco'],
            'duracao' => 'mensal',
            'dias_validade' => 30,
            'limite_aulas_dia' => $data['limite_aulas_dia'],
            'status' => true
        ]);

        foreach ($data['beneficios'] as $beneficio) {
            $planoMensal->beneficios()->create($beneficio);
        }

        $precoAnualBruto = $data['preco'] * 12;
        $precoAnualComDesconto = $precoAnualBruto * 0.8; // 20% desconto

        $planoAnual = Plano::create([
            'nome' => $data['nome'] . ' Anual',
            'preco' => round($precoAnualComDesconto, 2),
            'duracao' => 'anual',
            'dias_validade' => 365,
            'limite_aulas_dia' => $data['limite_aulas_dia'],
            'status' => true
        ]);

        foreach ($data['beneficios'] as $beneficio) {
            $planoAnual->beneficios()->create($beneficio);
        }

        return response()->json([
            'mensal' => $planoMensal->load('beneficios'),
            'anual' => $planoAnual->load('beneficios')
        ], 201);
    });
}


    public function toggle($id)
    {
        $plano = Plano::findOrFail($id);

        $plano->update([
            'status' => !$plano->status
        ]);

        return response()->json([
            'message' => 'Status atualizado com sucesso',
            'plano' => $plano
        ]);
    }
}
