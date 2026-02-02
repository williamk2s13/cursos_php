<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;
use App\Http\Requests\StorePlanoRequest;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(Plano::all());
    }

    public function store(StorePlanoRequest $request)
    {
        $plan = Plano::create($request->validated());
        return response()->json($plan, 201);
    }

    public function destroy($id)
    {
        $plan = Plano::findOrFail($id);
        $plan->delete();

        return response()->json([
            'message' => 'Plano deletado'
        ]);
    }
}
