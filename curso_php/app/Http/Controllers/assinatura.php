<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class assinatura extends Controller
{

    public function choose(Request $request)
    {
        $request->validate([
            'assinatura' => 'required|string|max:50'
        ]);

        $user = $request->user();
        $user->assinatura = $request->assinatura;
        $user->save();

        return response()->json([
            'message' => 'Assinatura definida com sucesso',
            'assinatura' => $user->assinatura
        ]);
    }
    public function show(Request $request)
    {
        return response()->json([
            'assinatura' => $request->user()->assinatura
        ]);
    }
    public function remove(Request $request)
    {
        $user = $request->user();
        $user->assinatura = null;
        $user->save();

        return response()->json([
            'message' => 'Assinatura removida'
        ]);
    }
}
