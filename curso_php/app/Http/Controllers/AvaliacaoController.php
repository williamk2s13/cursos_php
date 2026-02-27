<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    public function avaliar(Request $request, $cursoId)
{
    $request->validate([
        'nota' => 'required|integer|min:1|max:5',
    ]);

    $curso = Curso::find($cursoId);
    if (!$curso) {
        return response()->json(['message' => 'Curso não encontrado.'], 404);
    }

    $userId = Auth::id();
    
    Avaliacao::updateOrCreate(
        ['user_id' => $userId, 'curso_id' => $cursoId],
        ['nota' => $request->nota]
    );

    $curso->refresh(); 

    return response()->json([
        'message' => 'Avaliação registrada com sucesso!',
        'data' => [
            'nota_enviada' => $request->nota,
            'nova_media' => $curso->media_notas, 
            'total_votos' => $curso->total_avaliacoes
        ]
    ], 200);
}
}