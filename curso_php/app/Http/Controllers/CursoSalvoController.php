<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoSalvoController extends Controller
{
    public function toggle(Request $request, Curso $curso)
    {
        $user = $request->user();
        // Usar toggle é mais limpo que if/else
        $status = $user->cursosSalvos()->toggle($curso->id);
        $salvo = count($status['attached']) > 0;

        return response()->json(['salvo' => $salvo]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        // Carregamos os cursos com módulos e aulas
        $cursos = $user->cursosSalvos()
            ->with('modulos.aulas')
            ->get();

        // Calculamos o progresso para cada curso
        $cursos->map(function ($curso) use ($user) {
            $totalAulas = $curso->modulos->flatMap->aulas->count();
            
            if ($totalAulas > 0) {
                $concluidas = $user->aulasConcluidas()
                    ->whereIn('aula_id', $curso->modulos->flatMap->aulas->pluck('id'))
                    ->count();
                
                $curso->progresso = round(($concluidas / $totalAulas) * 100);
            } else {
                $curso->progresso = 0;
            }
            return $curso;
        });

        return response()->json($cursos);
    }

    public function verificarSalvo($id, Request $request)
    {
        $salvo = $request->user()->cursosSalvos()
            ->where('curso_id', $id)
            ->exists();

        return response()->json(['salvo' => $salvo]);
    }
}