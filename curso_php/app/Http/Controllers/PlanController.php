<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(Plano::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'  => 'required|string|unique:planos,nome',
            'preco' => 'required|numeric|min:0'
        ]);

        $plan = Plano::create([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'status' => true
        ]);

        return response()->json($plan, 201);
    }

    // deletar plano
    public function destroy($id)
    {
        $plan = Plano::findOrFail($id);
        $plan->delete();

        return response()->json([
            'message' => 'Plano deletado'
        ]);
    }
}
