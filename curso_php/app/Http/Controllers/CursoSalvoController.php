<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoSalvoController extends Controller
{
    public function toggle(Request $request, Curso $curso)
    {
        $user = $request->user();

        if ($user->cursosSalvos()->where('curso_id', $curso->id)->exists()) {
            $user->cursosSalvos()->detach($curso->id);
            return response()->json(['salvo' => false]);
        }

        $user->cursosSalvos()->attach($curso->id);

        return response()->json(['salvo' => true]);
    }

    public function index(Request $request)
    {
        return $request->user()
            ->cursosSalvos()
            ->with('modulos')
            ->get();
    }

    public function verificarSalvo($id, Request $request)
{
    $user = $request->user();

    $salvo = $user->cursosSalvos()
        ->where('curso_id', $id)
        ->exists();

    return response()->json([
        'salvo' => $salvo
    ]);
}
}
