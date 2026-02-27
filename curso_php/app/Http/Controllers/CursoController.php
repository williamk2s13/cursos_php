<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCursoRequest;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index()
    {
        return Curso::where('status', true)
            ->with('modulos.aulas')
            ->get();
    }

    public function meusCursos()
    {
        return Curso::where('professor_id', Auth::id())
            ->with('modulos.aulas')
            ->get();
    }

    public function store(StoreCursoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas', 'public');
        }

        $data['professor_id'] = Auth::id();
        $data['status'] = true;

        return Curso::create($data);
    }

   public function show(Curso $curso, Request $request)
{
    $curso->load('modulos.aulas');

    $user = $request->user();

    if ($user) {
        $aulasConcluidasIds = $user->aulasConcluidas()->pluck('aula_id')->toArray();

        foreach ($curso->modulos as $modulo) {
            foreach ($modulo->aulas as $aula) {
            
                $aula->foi_concluida = in_array($aula->id, $aulasConcluidasIds);
            }
        }
    }

    return response()->json($curso);
}
}