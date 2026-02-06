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
            Plano::with('beneficios')->get()
        );
    }

    public function store(StorePlanoRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $plano = Plano::create(
                $request->only(['nome', 'preco', 'status','pdf  '])
            );

            foreach ($request->beneficios as $beneficio) {
                $plano->beneficios()->create($beneficio);
            }

            return response()->json(
                $plano->load('beneficios'),
                201
            );
        });
    }

    public function destroy($id)
    {
        $plano = Plano::findOrFail($id);
        $plano->delete();

        return response()->json([
            'message' => 'Plano deletado'
        ]);
    }
}
